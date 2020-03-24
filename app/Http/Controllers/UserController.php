<?php

namespace App\Http\Controllers;

use Session;
use Validator;
use App\Model\User;
use App\model\Competence;
use App\Model\Departement;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function register_choice()
    {
        return view('users.register_choice');
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
        $avatar = Storage::disk('local')->url('users/normal/'. $user->avatar);

        return view('users.show', compact('user', 'avatar'));
    }

    public function edit($id)
    {
        $competences = Competence::all();
        $departements= Departement::all();
        $user = User::find($id);
        $user_competences = $user->competences;
        $user_departements = $user->departements;

        $avatar = Storage::url('users/normal/'. $user->avatar);
        $user = Auth::user();
        return view('users.edit', compact('user', 'avatar', 'competences', 'user_competences', 'departements', 'user_departements'));
    }

    public function imageUpload(Request $request)
    {
        $user = Auth::user();

        $value = $request->all();

        $rules = [
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ];

        $validator = Validator::make($value, $rules,[
            'avatar.image' => 'Seul les fichiers suivants sont admis: jpeg,png,jpg,gif,svg',
            'avatar.mimes' => 'Seul les fichiers suivants sont admis: jpeg,png,jpg,gif,svg',
            'avatar.max' => 'La taille du fichier doit être de 5mo maximum'

          ]);

        if($validator->fails()){
        return Redirect::back()
            ->withErrors($validator)
            ->withInput();
        }


        // On récupère l'avatar de la requête
        $avatar = $request->file('avatar');
        $extension = $request->file('avatar')->getClientOriginalExtension();


        //Intervention image

        $image = Image::make( $avatar )->resize(null, 500, function ($constraint) {
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
        DB::table('competence_user')->where('user_id', $user->id)->delete();
        DB::table('departement_user')->where('user_id', $user->id)->delete();
        $user->competences()->attach($request->competences);
        $user->departements()->attach($request->departements);

        $user->firstname = $request['firstname'];
        $user->lastname = $request['lastname'];
        $user->alert_competences = $request['alert_competences'];
        $user->alert_departements = $request['alert_departements'];
        $user->description = $request['presentation'];
        $user->titre = $request['titre'];

            $user->update();

        return redirect()->back();
    }

}
