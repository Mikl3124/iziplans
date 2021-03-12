<?php

namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Offer;
use App\Model\Topic;
use App\Model\Budget;
use App\Model\Projet;
use App\Mail\Newprojet;
use App\Model\Category;
use App\Model\Competence;
use App\Model\Departement;
use Illuminate\Http\Request;
use App\Mail\NewProjetPosted;
use App\Model\Standbyproject;
use MercurySeries\Flashy\Flashy;
use App\Mail\NewprojetDepartement;
use Illuminate\Support\Facades\DB;
use App\Jobs\MailNewProjetForAdmin;
use App\Mail\ConfirmMessageToAuthor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewProjetPostedForAdmin;
use App\Mail\ConfirmValidationToAuthor;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Jobs\MailConfirmMessageToAuthor;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use App\Jobs\MailConfirmValidationToAuthor;
use App\Jobs\MailMatchCompetenceToFreelance;
use App\Jobs\MailMatchDepartementToFreelance;

class ProjetController extends Controller

{
  public function __construct()
  {
    $this->middleware('auth')->only(['store', 'create']);
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  {

    $projets = Projet::where("status", "=", "open")->orwhere("status", "=", "closed")->orderBy('created_at', 'desc')->paginate(6);

    return view('projets.index', compact('projets'));
  }

  public function myprojets()
  {

    $projets = Projet::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(6);

    return view('projets.index', compact('projets'));
  }

  public function list()
  {

    $projets_client = Projet::where('user_id', Auth::user()->id)->get();
    $offres_freelance = Offer::where('user_id', Auth::user()->id)->get();

    return view('projets.list', compact('projets_client', 'offres_freelance'));
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $categories = Category::all();
    $departements = Departement::all();
    $budgets = Budget::all();


    return view('projets.create', compact('categories', 'departements', 'budgets'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $input = $request->all();
    //On vérifie si l'utilisateur est connecté, si c'est le cas on joint l'user id.
    if (Auth::check()) {
      $user_id = Auth::user()->id;

      $input['user_id'] = $user_id;
    } else {
      // Si l'utilisateur n'est pas connecté, on se dirige à la page register client.

      Session::put('filled_form', $input);
      return redirect()->route('register', 'client');
    }

    $this->validate($request, [
      'categories' => 'bail|required',
      'title' => 'bail|required|string|max:255',
      'file-projet' => 'sometimes|max:5000',
      'description' => 'bail|required',
      'budget' => 'bail|required',
      'departement' => 'bail|required'
    ]);

    $user = Auth::user();
    $projet = new Projet;
    $projet->user_id = $user->id;
    $projet->title = $request->title;
    $projet->description = $request->description;
    $projet->status = 'pending';
    $projet->departement_id = $request->departement;

    if ($files = $request->file('file_projet')) {
      $filenamewithextension = $request->file('file_projet')->getClientOriginalName();

      //get filename without extension
      $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

      //get file extension
      $extension = $request->file('file_projet')->getClientOriginalExtension();

      //filename to store
      //$path = 'documents/' . $user->lastname. '_' . $user->firstname . '_' . time();

      $filenametostore = $filename . '_' . time() . '.' . $extension;

      //Upload File

      Storage::putFileAs('documents', $request->file('file_projet'), $filenametostore);

      //Store $filenametostore in the database
      $projet->file_projet = $filenametostore;
    }

    $projet->budget_id = $request->budget;
    $projet->save();
    $projet->categories()->attach($request->categories);

    if (Auth::check()) {
      $categories = $request->categories;
      $departement_id = $request->departement;

      $departement = Departement::find($departement_id);

      // On sélectionne les users concernés par au moins une des compétences et qui ont choisis d'être informés

      $freelances_categories = User::where('alert_categories', 1)
        ->where('role', 'freelance')
        ->whereHas('categories', function ($query) use ($categories) {
          $query->whereIn('category_id', $categories);
        })->get();
      //Mail à l'Admin
      dd(env("MAIL_ADMIN"), $user, $projet);
      Mail::to("mickael@iziplans.com")
        ->send(new NewProjetPostedForAdmin($user, $projet));

      // $this->dispatch(new MailNewProjetForAdmin($user, $projet));

      // On envoie un email de confirmation à l'user
      $author = Auth::user();
      Mail::to($author->email)
        ->send(new ConfirmMessageToAuthor($projet, $author));
      // $this->dispatch(new MailConfirmMessageToAuthor($author, $projet));

      Flashy::success('Votre mission a été enregistrée avec succès');
      return redirect()->route('home');
    }

    return view('auth.register', compact('role', 'projet'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Projet $projet)
  {
    $departement = Departement::find($projet->departement_id);
    $offers = Offer::where('projet_id', $projet->id)->get();
    $has_make_an_offer = false;
    $topic = null;
    $freelance_offer = null;
    $already_make_a_bid = null;

    if ($projet->file_projet) {
      $contents = Storage::url($projet->file_projet);
    } else {
      $contents = NULL;
    }

    if (isset(Auth::user()->id)) {
      $topic = Topic::where('projet_id', $projet->id)
        ->where('from_id', Auth::user()->id)
        ->first();
      if ($topic === null) {
        $topic = 0;
      }
      foreach ($offers as $offer) {
        if ($offer->user_id == Auth::user()->id) {
          $has_make_an_offer = true;
          $freelance_offer = Offer::where('user_id', Auth::user()->id)
            ->where('projet_id', $projet->id)
            ->first();
        }
      }
      $already_make_a_bid = Offer::where('projet_id', $projet->id)
        ->where('user_id', Auth::user()->id)
        ->first();
    }



    views($projet)->record();
    return view('projets.show', compact('projet', 'topic', 'contents', 'offers', 'departement', 'has_make_an_offer', 'freelance_offer', 'already_make_a_bid'));
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $projet = Projet::find($id);
    $categories = Category::all();
    $budgets = Budget::all();
    $departements = Departement::all();
    if (Auth::user()->id === $projet->user_id) {
      return view('projets.edit', compact('projet', 'categories', 'budgets', 'departements'));
    }
    return redirect()->back();
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
    $projet = Projet::find($id);

    $user = Auth::user();
    if ($user->id === $projet->user_id) {
      if (Auth::check()) {

        $this->validate($request, [
          'categories' => 'bail|required',
          'title' => 'bail|required|string|max:255',
          'file-projet' => 'sometimes|max:5000',
          'description' => 'bail|required',
          'budget' => 'bail|required',
          'departement' => 'bail|required'
        ]);

        $projet->user_id = $user->id;
        $projet->title = $request->title;
        $projet->description = $request->description;
        $projet->status = 'open';
        $projet->departement_id = $request->departement;


        if ($files = $request->file('file_projet')) {
          $filenamewithextension = $request->file('file_projet')->getClientOriginalName();

          //get filename without extension
          $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

          //get file extension
          $extension = $request->file('file_projet')->getClientOriginalExtension();

          $filenametostore = $filename . '_' . time() . '.' . $extension;

          //Upload File
          Storage::putFileAs('documents', $request->file('file_projet'), $filenametostore);

          //Store $filenametostore in the database
          $projet->file_projet = $filenametostore;
        }

        $projet->budget_id = $request->budget;


        if ($projet->save()) {
          DB::table('category_projet')->where('projet_id', $projet->id)->delete();
          $projet->categories()->attach($request->categories);
        };
      }
      Flashy::success('Votre projet a été modifié avec succès !');
      return redirect()->route('projet.show', $projet);
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
    //
  }

  public function download($id)
  {
    $dl = Projet::find($id);
    return Storage::download('documents/' . $dl->file_projet);
  }

  public function close(Request $request)
  {
    $projet = Projet::find($request->projet_id);
    if (Auth::user()->id === $projet->user_id) {
      $projet->status = "closed";
      $projet->save();
      Flashy::error('Votre projet a été fermé');
      return redirect()->back();
    }
    return redirect()->back();
  }

  public function open($id)
  {
    $projet = Projet::find($id);
    if (Auth::user()->id === $projet->user_id) {
      $projet->status = "open";
      $projet->save();
      Flashy::success('Votre projet a été publié avec succès !');
      return redirect()->route('home');
    }
    return redirect()->back();
  }

  public function validateProjet(Request $request)
  {
    $projet = Projet::find($request->projet_id);
    if ($projet->status === 'pending') {
      $projet = Projet::find($request->projet_id);
      $projet->status = "open";
      if ($projet->save()) {
        $categories = $projet->categories;
        $departement_id = $projet->departement;

        $departement = Departement::find($departement_id)->first();

        // On envoie un email aux freelancer concernés par les compétences
        $author = User::find($projet->user_id);
        Mail::to($author->email)
          ->send(new ConfirmValidationToAuthor($projet, $author));
        // $this->dispatch(new MailConfirmValidationToAuthor($author, $projet));

        // On sélectionne les users concernés par au moins une des compétences et qui ont choisis d'être informés

        $freelances_categories = User::where('alert_categories', 1)
          ->where('role', 'freelance')
          ->whereHas('categories', function ($query) use ($categories) {
            $query->whereIn('category_id', $categories);
          })->get();

        // On envoie un email aux freelancer concernés par les compétences
        foreach ($freelances_categories as $freelance_category) {
          $user = $freelance_category;
          Mail::to($user->email)
            ->send(new Newprojet($projet, $user));
          // $this->dispatch(new MailMatchCompetenceToFreelance($user, $projet));
        }


        // On sélectionne les users concernés par au moins un des départements et qui ont choisis d'être informés
        $freelances_departements = User::where('role', 'freelance')
          ->where('alert_departements', 1)
          ->whereHas('departements', function ($query) use ($departement) {
            $query->where('departement_id', $departement->id);
          })->get();

        // On envoie un email aux freelancer concernés par le lieux
        foreach ($freelances_departements as $freelance_departement) {
          $user = $freelance_departement;
          Mail::to($user->email)
            ->send(new Newprojet($projet, $user));
          // $this->dispatch(new MailMatchDepartementToFreelance($user, $projet));
        }
        Flashy::success('Le projet a été validé');
        return redirect()->back();
      }
    }
    if ($projet->status === 'open') {
      $projet = Projet::find($request->projet_id);
      $projet->status = "pending";
      if ($projet->save()) {
      }
      Flashy::success('Le projet a été mis en pause');
      return redirect()->back();
    }

    Flashy::error('Un problème est survenu');
    return redirect()->back();
  }
}
