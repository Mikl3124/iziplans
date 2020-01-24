<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Projet;
use App\model\Category;
use App\model\Competence;
use App\Model\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
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
                 "4" => "2000€ de 3000€",
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
                'localisation' => 'bail|required'
                ]);

                    $projet = new Projet;

                    $projet->user_id = $user->id;
                    $projet->title = $request->title;
                    $projet->description = $request->description;

                    if ($files = $request->file('file_projet')) {
                        Storage::disk('local')->put($files);
                        $projet->file_projet = time().$files->getClientOriginalName();
                    }

                    $projet->budget = $request->budget;
                    $projet->localisation = $request->localisation;

                    if ($projet->save()){
                        $projet->categories()->attach($request->categories);
                        $projet->competences()->attach($request->competences);
                    };



                return redirect()->route('home')->with('success', 'Votre mission a étée postée');


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
        return view('projets.show', compact('projet'));
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
}
