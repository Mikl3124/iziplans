<?php

namespace App\Http\Controllers;

use Validator;
use App\Model\Offer;
use App\Model\Projet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class OfferController extends Controller
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
    public function create($id)
    {
        $projet = Projet::find($id);
        return view('offers.create', compact('projet'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $values = $request->all();
        $user = Auth::user();

        $rules = [
            'offer_price' => 'required|integer',
            'offer_days' => 'required|integer',
            'offer_message' => 'required',
            'file' => 'mimes:pdf,xlx,csv,jpeg,png,jpg,doc,docx|max:4096'
        ];

        $validator = Validator::make($values, $rules,[
            'offer_price.required' => 'Votre offre est obligatoire',
            'offer_price.integer' => 'Votre offre doit être un nombre',
            'offer_days.required' => 'Le nombre de jours est obligatoire',
            'offer_days.integer' => 'La durée doit être un nombre',
            'offer_message.required' => 'Un petit mot est obligatoire',
            'file.mime' => 'Seul les fichiers suivants sont admis: pdf,xlx,csv,jpeg,png,jpg,doc,docx',
            'file.max' => 'La taille du fichier doit être de 4Mo maximum'
            
          ]);
        if($validator->fails()){
        return Redirect::back()
            ->withErrors($validator)
            ->withInput();
        }
        
        $offer = new Offer;
                    $offer->projet_id = $request->projet_id;
                    $offer->user_id = $user->id;
                    $offer->offer_price = $request->offer_price;
                    $offer->offer_days = $request->offer_days;
                    $offer->offer_message = $request->offer_message;

        if ($files = $request->file('filename')) {
            $filenamewithextension = $request->file('filename')->getClientOriginalName();
    
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
    
            //get file extension
            $extension = $request->file('filename')->getClientOriginalExtension();
    
            //filename to store
            $path = 'documents/' . $user->lastname. '_' . $user->firstname . '_' . time();
            $filenametostore = $path.'/'.$filename.'_'.time().'.'.$extension;
    
            //Upload File to s3
            
            //Storage::disk('s3')->put($filenametostore, fopen($request->file('filename'), 'r+'), 'public');
            Storage::disk('s3')->put($filenametostore, $request->file('filename'), 'public');
    
            //Store $filenametostore in the database
            $offer->filename = $filenametostore;
        }
        $offer->save();

    return redirect()->route('home')->with('success', 'Votre offre a bien été postée');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
