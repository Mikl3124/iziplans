<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Offer;
use App\Model\Projet;
use App\Mail\Newprojet;
use App\model\Category;
use App\model\Competence;
use App\Model\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class ProjetController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $competences = Competence::all();
        $departements= Departement::all();

        $budgets = ["1" => "Moins de 500€",
                 "2" => "500€ à 1000€",
                 "3" => "1000€ à 2000€",
                 "4" => "2000€ à 3000€",
                 "5" => "Plus de 3000€",
            ];


        return view('projets.create', compact('categories' , 'competences', 'departements', 'budgets'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if(Auth::check()){

            $this->validate($request, [
                'categories' => 'bail|required',
                'title' => 'bail|required|string|max:255',
                'file-projet' => 'sometimes|max:5000',
                'competences' => 'bail|required',
                'description' => 'bail|required',
                'budget' => 'bail|required',
                'departement' => 'bail|required'
                ]);

                    $projet = new Projet;

                    $projet->user_id = $user->id;
                    $projet->title = $request->title;
                    $projet->description = $request->description;
                    $projet->status = 'publish';
                    $projet->departement_id = $request->departement;

                    if ($files = $request->file('file_projet')) {
                        $filenamewithextension = $request->file('file_projet')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('file_projet')->getClientOriginalExtension();

            //filename to store
            $path = 'documents/' . $user->lastname. '_' . $user->firstname . '_' . time();

            $filenametostore = $path.'/'.$filename.'_'.time().'.'.$extension;

                        //Upload File to s3

                        //Storage::disk('s3')->put($filenametostore, fopen($request->file('file_projet'), 'r+'), 'public');
                        Storage::disk('s3')->put($filenametostore, $request->file('file_projet'), 'public');

                        //Store $filenametostore in the database
                        $projet->file_projet = $filenametostore;
                    }

                    $projet->budget = $request->budget;
                    

                    if ($projet->save()){
                        $projet->categories()->attach($request->categories);
                        $projet->competences()->attach($request->competences);
                    };

                $competences = $request->competences;
                $departement_id = $request->departement;

                $departement = Departement::find($departement_id);

                // On sélectionne les users concernés par au moins une des compétences et qui ont choisis d'être informés
                $freelances_competences = User::where('alert_competences', 1)
                                                ->where('role', 'freelance')
                                                ->whereHas('competences', function ($query) use ($competences) {
                                                    $query->whereIn('competence_id', $competences);
                                                })->get();

                // On envois un email aux freelancer concernés par les compétences
                foreach($freelances_competences as $freelance_competence){
                    Mail::to($freelance_competence->email)->queue(new Newprojet($projet));
                }

                // On sélectionne les users concernés par au moins un des départements et qui ont choisis d'être informés
                $freelances_departements = User::where('role', 'freelance')
                                                ->where('alert_departements', 1)
                                                ->whereHas('departements',function($query) use ($departement) {
                                                    $query->where('departement_id', $departement->id);
                                                   })->get();
                


                // On envois un email aux freelancer concernés par le lieux
                foreach($freelances_departements as $freelance_departement){
                    Mail::to($freelance_departement->email)->queue(new Newprojet($projet));
                }

                return redirect()->route('home')->with('success', 'Votre mission a été postée');

            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Projet $projet)
    {

        //$download = Storage::disk('s3')->download($projet->file_projet);
        if ($projet->file_projet) {
            $contents = Storage::disk('s3')->url($projet->file_projet);
        } else {
            $contents = NULL;
        }

        $departement = Departement::find($projet->departement_id);
        $offers = Offer::where('projet_id', $projet->id)->get();

        return view('projets.show', compact('projet', 'contents', 'offers', 'departement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function download($id)
    {

        $dl = Projet::find($id);
        return Storage::disk('s3')->download($dl->file_projet);

    }


}
