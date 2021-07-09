<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use App\Model\User;
use Stripe\Customer;
use App\Model\Category;
use App\Model\Competence;
use App\Model\Departement;
use App\Model\Information;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use NSpehler\LaravelInsee\Facades\Insee;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth')->only(['edit', 'subscription', 'imageUpload']);
  }

  public function register_choice()
  {
    return view('auth.register_choice');
  }

  public function register_client()
  {
    $role = 'client';
    Session::put('role', $role);
    return view('auth.register', compact('role'));
  }

  public function register_freelance()
  {
    $role = 'freelance';
    Session::put('role', $role);
    return view('auth.register', compact('role'));
  }


  public function show($id)
  {

    $user = User::find($id);
    $avatar = $user->avatar;

    return view('users.show', compact('user', 'avatar'));
  }

  public function edit($id)
  {
    $categories = Category::all();
    $departements = Departement::all();
    $user = User::find($id);
    $user_categories = $user->categories;
    $user_departements = $user->departements;

    $avatar = Storage::url('users/normal/' . $user->avatar);
    $user = Auth::user();
    return view('users.edit', compact('user', 'avatar', 'categories', 'user_categories', 'departements', 'user_departements'));
  }

  public function subscription($id)
  {
    $user = User::find($id);

    if (Auth::user()->id === $user->id) {
      if ($user->id === Auth::user()->id && Auth::user()->role === 'freelance') {
        if (Auth::user()->stripe_id) {
          $invoices = $user->invoices();
          if ($user->asStripeCustomer()["subscriptions"]->data === null) {
            return redirect()->route('subscribe');
          };
          $endOfPeriod = $user->asStripeCustomer()["subscriptions"]->data[0]["current_period_end"];
          $originalDateEnd = Auth::user()->subscription('abonnement')->ends_at;
          $date_end = Carbon::parse($originalDateEnd)->isoFormat('LL');
          $nextPayment = Carbon::parse($endOfPeriod)->isoFormat('LL');
          $subscription = Auth::user()->subscriptions()->first();
          return view('users.freelance.subscription', compact('user', 'invoices', 'subscription', 'date_end', 'nextPayment'));
        }
        return redirect()->route('subscribe');
      }
    }

    return redirect()->route('subscribe');
  }

  public function imageUpload(Request $request)
  {
    $user = Auth::user();

    $value = $request->all();

    $rules = [
      'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
    ];

    $validator = Validator::make($value, $rules, [
      'avatar.image' => 'Seul les fichiers suivants sont admis: jpeg,png,jpg,gif,svg',
      'avatar.mimes' => 'Seul les fichiers suivants sont admis: jpeg,png,jpg,gif,svg',
      'avatar.max' => 'La taille du fichier doit être de 5mo maximum'

    ]);

    if ($validator->fails()) {
      return Redirect::back()
        ->withErrors($validator)
        ->withInput();
    }


    // On récupère l'avatar de la requête
    $avatar = $request->file('avatar');
    $extension = $request->file('avatar')->getClientOriginalExtension();


    //Intervention image

    $image = Image::make($avatar)->resize(null, 500, function ($constraint) {
      $constraint->aspectRatio();
      $constraint->upsize();
    });

    // Récupération du nom
    $filename = basename(Storage::put('', $avatar));

    Storage::put($filename, $image->stream());


    // On efface l'ancien avatar
    Storage::delete($user->filename);

    // On stock le nouvel avatar
    //Storage::put('', $image);

    // Assignation du nom à l'avatar en BDD
    $store_name = Storage::url($filename);
    //Sauvegarde l'adresse dans la BDD
    $user->avatar = $store_name;
    //Sauvegarde du nom du fichier dans la BDD (pour effacements)
    $user->filename = $filename;
    // On sauvegarde User
    $user->save();

    return redirect()->back();
  }

  public function update(Request $request)
  {
    $user = Auth::user();

    $value = $request->all();

    $rules = [
      'email' => 'required|email',
      'firstname' => 'required|min:3',
      'lastname' => 'required|min:3',
    ];

    $validator = Validator::make($value, $rules, []);

    if ($validator->fails()) {
      Flashy::error("Il y a une erreur dans le formulaire");
      return Redirect::back()
        ->withErrors($validator)
        ->withInput();
    }

    //Mise à jour du profil
    DB::table('category_user')->where('user_id', $user->id)->delete();
    DB::table('departement_user')->where('user_id', $user->id)->delete();
    $user->categories()->attach($request->categories);
    $user->departements()->attach($request->departements);
    $user->firstname = $request['firstname'];
    $user->lastname = $request['lastname'];
    $user->pseudo = $request['pseudo'];
    $user->alert_categories = $request['alert_categories'];
    $user->alert_departements = $request['alert_departements'];
    $user->presentation = $request['presentation'];
    $user->phone = $request['phone'];
    $user->titre = $request['titre'];
    $user->address = $request['address'];
    $user->town = $request['town'];
    $user->cp = $request->cp;
    $user->departement = $request->departement;

    // Mise à jour de updated_profil
    if ($user->categories->count() >= 1 || $user->departements->count() >= 1) {
      $user->updated_profil = 1;
    } else {
      $user->updated_profil = 0;
    }

    $user->update();

    Flashy::success('Votre profil a été mis à jour avec succès !');
    return redirect()->back();
  }

  public function changeRole()
  {
    $user = Auth::user();
    if (Auth::user()->role === 'client') {
      $user->role = 'freelance';
      $user->save();
      Flashy::success("Vous avez basculé sur l'interface FREELANCE");
      return redirect()->back();
    }

    if (Auth::user()->role === 'freelance') {
      $user->role = 'client';
      $user->save();
      Flashy::success("Vous avez basculé sur l'interface CLIENT");
      return redirect()->back();
    }
  }

  public function changePassword(Request $request)
  {
    $user = Auth::user();
    $value = $request->all();

    $rules = [
      'password' => ['confirmed'],
    ];

    $validator = Validator::make($value, $rules, [
      'password.confirmed' => 'Les mots de passes ne sont pas identiques',

    ]);

    if ($validator->fails()) {
      Flashy::error("Les mots de passe ne sont pas identiques");
      return Redirect::back()
        ->withErrors($validator)
        ->withInput();
    } else {
      $user->password = Hash::make($request['password']);
      $user->save();
      Flashy::success("Mot de passe modifié");
      return Redirect::back();
    }
  }
}
