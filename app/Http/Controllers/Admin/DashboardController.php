<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use App\Model\Projet;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function registered()
    {
        $projets = Projet::all();
        $users = User::all();
        $usersinc = User::all()->sortBy('lastname');
        $usersdesc = User::all()->sortBy('lastname');
        return view('admin.user-register')
                ->with('users', $users)
                ->with('usersinc', $usersinc)
                ->with('usersdesc', $usersdesc)
                ->with('projets', $projets);
    }


    public function posted()
    {

        $projets = Projet::all();
        return view('admin.projet-register')
                ->with('projets', $projets);
    }

    public function projetbyuser(Request $request, $id)
    {
        $user_id = $id;
        $projets = Projet::where('user_id', $user_id)->get();
        return view('admin.projet-register')
                    ->with('projets', $projets);

    }



    public function registeredit(Request $request, $id)
    {
        $users = User::findOrFail($id);
        return view('admin.user-edit')->with('users', $users);
    }

    public function projetedit(Request $request, $id)
    {
        $categories = Category::all();
        $projet = Projet::findOrFail($id);
        return view('admin.projet-edit')
                ->with('projet', $projet)
                ->with('categories', $categories);
    }

    public function registerupdate(Request $request, $id)
    {
        $users = User::find($id);
        $users->firstname = $request->input('firstname');
        $users->lastname = $request->input('lastname');
        $users->email = $request->input('email');
        $users->update();

        return redirect('user-register')->with('success', 'L\'utilisateur a été mis à jour');
    }

    public function registerdelete($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect('user-register')->with('success', 'L\'utilisateur a été supprimé.');
    }

    public function projetdelete($id)
    {
        $projets = Projet::findOrFail($id);
        $projets->delete();

        return redirect('projet-register')->with('success', 'Le projet a été supprimée.');
    }

     public function projetupdate(Request $request, $id)
    {

        $projet = Projet::find($id);
        $projet->title = $request->input('title');
        $projet->description = $request->input('description');
        $projet->budget = $request->input('budget');
        $projet->status = $request->input('status');
        $projet->update();


        // if ($projet->save()){
        // $cat_to_delete = Category::where('projet_id', $request->input('id'))->delete();

        // $tool->categories()->attach($request->categories);
        // };

        return redirect('projet-register')->with('success', 'Le projet a été mise à jour');
    }

    public function data()
    {
        $projets = Projet::all();
        $users = User::all();
        $lastprojet = Projet::orderBy('id', 'desc')->take(1)->get();
        $lastuser = User::orderBy('id', 'desc')->take(1)->get();

        return view('admin.dashboard')
                ->with('users', $users)
                ->with('projets', $projets)
                ->with('lastuser', $lastuser)
                ->with('lastprojet', $lastprojet);
    }

    public function connect_as($user)
    {
        if(Auth::user()->role === 'admin'){
            Auth::loginUsingId($user, true);
            return redirect()->back();
        }
        return redirect()->back();

    }

}
