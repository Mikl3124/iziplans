<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Offer;
use App\Model\Topic;
use App\Model\Projet;
use App\Model\Message;
use App\Mail\NewMessage;
use App\Jobs\MailNewMessage;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Notifications\NewMessagePosted;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Console\Input\Input;
use Illuminate\Contracts\Validation\Validator;

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
        $user = $projet->user;

        $topic = Topic::where('projet_id', $projet->id)
            ->where('from_id', Auth::user()->id)
            ->first();

        Mail::to($user->email)
            ->send(new NewMessage($projet, $user));
        // $this->dispatch(new MailNewMessage($message_to, $projet));
        if ($topic === null) {
            $topic = 0;
        }

        return view('offers.create', compact('projet', 'topic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $projet = Projet::find($request->projet_id);
        $offers = Offer::where('projet_id', $projet->id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if ($offers) {
            Flashy::error('Vous avez déjà fait une offre pour ce projet...');
            return redirect()->back();
        }

        $values = $request->all();
        $user = Auth::user();

        $rules = [
            'offer_price' => 'required|integer',
            'offer_days' => 'required|integer',
            'offer_message' => 'required',
            'file' => 'mimes:pdf,xlx,csv,jpeg,png,jpg,doc,docx|max:4096'
        ];

        $validator = Validator::make($values, $rules, [
            'offer_price.required' => 'Votre offre est obligatoire',
            'offer_price.integer' => 'Votre offre doit être un nombre',
            'offer_days.required' => 'Le nombre de jours est obligatoire',
            'offer_days.integer' => 'La durée doit être un nombre',
            'offer_message.required' => 'Un petit mot est obligatoire',
            'file.mimes' => 'Seul les fichiers suivants sont admis: pdf,xlx,csv,jpeg,png,jpg,doc,docx',
            'file.max' => 'La taille du fichier doit être de 4Mo maximum'

        ]);
        if ($validator->fails()) {
            return Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $topic = new Topic;
        $topic->title = $projet->title;
        $topic->from_id = Auth::user()->id;
        $topic->to_id = $projet->user_id;
        $topic->projet_id = $projet->id;

        $topic->save();

        $message = new Message;
        $message->from_id = $user->id;
        $message->to_id = $projet->user_id;
        $message->content = $request->offer_message;
        $message->projet_id = $projet->id;
        $message->topic_id = $topic->id;


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
            //$path = 'documents/' . $user->lastname. '_' . $user->firstname . '_' . time();

            $filenametostore = $filename . '_' . time() . '.' . $extension;


            //Upload File

            Storage::putFileAs('documents', $request->file('filename'), $filenametostore);

            //Store $filenametostore in the database

            $message->file_message = $filenametostore;
        }
        $offer->save();
        $message->save();

        // Notification
        $message_to = User::find($projet->user_id);
        $message_to->notify(new NewMessagePosted($topic, auth()->user()));

        Flashy::success('Votre offre a bien été enregistrée');
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $offer = Offer::find($id);
        if (Auth::user()->id === $offer->user_id || Auth::user()->id === $offer->projet->user_id) {
            return view('offers.show', compact('offer'));
        }
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offer = Offer::find($id);

        if ($offer->user_id === Auth::user()->id) {
            $projet = Projet::find($offer->projet_id);
            $topic = Topic::where('projet_id', $projet->id)
                ->where('from_id', Auth::user()->id)
                ->first();
            if ($topic === null) {
                $topic = 0;
            }

            return view('offers.edit', compact('offer', 'projet', 'topic'));
        }
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
        $offer = Offer::find($id);

        $user = Auth::user();
        if ($user->id === $offer->user_id) {
            if (Auth::check()) {
                $rules = [
                    'offer_price' => 'required|integer',
                    'offer_days' => 'required|integer',
                    'offer_message' => 'required',
                    'file' => 'mimes:pdf,xlx,csv,jpeg,png,jpg,doc,docx|max:4096'
                ];

                $validator = Validator::make($values, $rules, [
                    'offer_price.required' => 'Votre offre est obligatoire',
                    'offer_price.integer' => 'Votre offre doit être un nombre',
                    'offer_days.required' => 'Le nombre de jours est obligatoire',
                    'offer_days.integer' => 'La durée doit être un nombre',
                    'offer_message.required' => 'Un petit mot est obligatoire',
                    'file.mimes' => 'Seul les fichiers suivants sont admis: pdf,xlx,csv,jpeg,png,jpg,doc,docx',
                    'file.max' => 'La taille du fichier doit être de 4Mo maximum'

                ]);
                if ($validator->fails()) {
                    return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
                }

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
                    //$path = 'documents/' . $user->lastname. '_' . $user->firstname . '_' . time();

                    $filenametostore = $filename . '_' . time() . '.' . $extension;


                    //Upload File

                    Storage::putFileAs('documents', $request->file('filename'), $filenametostore);

                    //Store $filenametostore in the database

                }
                $offer->save();
                Flashy::success('Votre offre a été modifié avec succès !');
                return redirect()->back();
            }
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $offer = Offer::find($id);
        if (Auth::user()->id === $offer->user_id || Auth::user()->role === 'admin') {
            $offer->delete();
            Flashy::error('Votre offre a bien été supprimée');
            return redirect()->route('home');
        }
        return redirect()->back();
    }
}
