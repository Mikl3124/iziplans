<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use App\Model\Offer;
use App\Model\Budget;
use App\Model\Projet;
use App\Model\Category;
use App\Model\Departement;
use Illuminate\Http\Request;
use MercurySeries\Flashy\Flashy;
use Illuminate\Support\Facades\DB;
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

    public function offerbyuser(Request $request, $id)
    {
        $user_id = $id;
        $user = User::find($id);
        $offers = Offer::where('user_id', $user_id)->get();
        return view('admin.offer-register')
                    ->with('offers', $offers)
                    ->with('user', $user);
    }

    public function projetShow(Request $request, $id)
    {
        $projet = Projet::find($id);
            return view('admin.projet-show')
                        ->with('projet', $projet);
    }


    public function registeredit(Request $request, $id)
    {
        $users = User::findOrFail($id);
        return view('admin.user-edit')->with('users', $users);
    }

    public function projetedit(Request $request, $id)
    {   
        $departements = Departement::all();
        $categories = Category::all();
        $budgets = Budget::all();
        $projet = Projet::findOrFail($id);
        return view('admin.projet-edit')
                ->with('projet', $projet)
                ->with('budgets', $budgets)
                ->with('departements', $departements)
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

        $user = $projet->user;
            if(Auth::check()){
                dd($request);
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
                        $projet->status = $request->status;
                        $projet->departement_id = $request->departement;


                        if ($files = $request->file('file_projet')) {
                            $filenamewithextension = $request->file('file_projet')->getClientOriginalName();

                            //get filename without extension
                            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                            //get file extension
                            $extension = $request->file('file_projet')->getClientOriginalExtension();

                            $filenametostore = $filename.'_'.time().'.'.$extension;

                            //Upload File
                            Storage::putFileAs('documents', $request->file('file_projet'), $filenametostore);

                            //Store $filenametostore in the database
                            $projet->file_projet = $filenametostore;
                        }

                        $projet->budget_id = $request->budget;


                        if ($projet->save()){
                            DB::table('category_projet')->where('projet_id', $projet->id)->delete();
                            $projet->categories()->attach($request->categories);
                        };
            Flashy::success('Votre projet a été modifié avec succès !');
            return redirect('projet-register');
        }

        return redirect('projet-register');
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
