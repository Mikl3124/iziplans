<?php

namespace App\Http\Controllers;

use Session;
use App\Model\User;
use App\model\Competence;
use App\Model\Departement;
use Illuminate\Http\Request;
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

        request()->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
        ]);
        $avatar = $request->file('avatar');

        $filename = md5(time()).'_'.$avatar->getClientOriginalName();
        $normal = Image::make($avatar)->save();
        $medium = Image::make($avatar)->fit(80, 80)->save();
        $small = Image::make($avatar)->fit(40, 40)->save();
        // $normal = Image::make($avatar)->resize(160, 160)->encode('png', 75);
        // $medium = Image::make($avatar)->resize(80, 80)->encode('png', 75);
        // $small = Image::make($avatar)->resize(40, 40)->encode('png', 75);

        Storage::put('/users/normal/'.$filename, (string)$normal, 'public');

        Storage::put('/users/medium/'.$filename, (string)$medium, 'public');

        Storage::put('/users/small/'.$filename, (string)$small, 'public');

        $user->avatar = $filename;
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
