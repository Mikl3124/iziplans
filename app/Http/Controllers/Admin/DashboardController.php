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
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function usersList()
    {
        $projets = Projet::all();
        $users = User::where('id', '!=', auth()->id())->get();

        return view('admin.users-list')
                ->with('users', $users)
                ->with('projets', $projets);
    }


    public function projetsList()
    {
        $projets = Projet::all();
        return view('admin.projets-list')
                ->with('projets', $projets);
    }

    public function projetsByUser(Request $request, $id)
    {
        $user_id = $id;
        $user = User::find($id);
        $projets = Projet::where('user_id', $user_id)->get();
        return view('admin.projets-by-user')
                    ->with('projets', $projets)
                    ->with('user', $user);
    }

    public function offersByUser(Request $request, $id)
    {
        $user_id = $id;
        $user = User::find($id);
        $offers = Offer::where('user_id', $user_id)->get();
        return view('admin.offers-by-user')
                    ->with('offers', $offers)
                    ->with('user', $user);
    }

    public function offerEdit(Request $request, $id)
    {
        $offer = Offer::find($id);
        return view('admin.offer-edit')
                    ->with('offer');
    }

    public function userEdit(Request $request, $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-edit')->with('user', $user);
    }

    public function projetEdit(Request $request, $id)
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

    public function userUpdate(Request $request, $id)
    {
        $user = User::find($id);
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->role = $request->input('role');

        if($user->update()){
            Flashy::success("L'utilisateur a été modifié avec succès !");
            return redirect( route('admin.user.edit', $user->id));
        } else {
            Flashy::error('Une erreur est survenue !');
            return redirect( route('admin.user.edit', $user->id));
        }

    }

    public function userDelete($id)
    {
        $users = User::findOrFail($id);
        if($users->delete()){
            $projets = Projet::where('user_id', $id)->get();
            $offers = Offer::where('user_id', $id)->get();

            foreach($projets as $projet){
                $projet->delete();
            }
            foreach($offers as $offer){
                $offer->delete();
            }
            Flashy::success("L'utilisateur a été supprimé avec succès");
            return redirect( route('admin.users.list') );
        } else{
            Flashy::error("L'utilisateur n'a pas été supprimé'");
            return redirect( route('admin.users.list') );
        }


    }

    public function projetDelete($id)
    {
        $projets = Projet::findOrFail($id);
        if ($projets->delete()){
            Flashy::success('Projet supprimé avec succès');
            return redirect( route('admin.projets.list') );
        } else{
            Flashy::error("Le projet n'a pas été supprimé");
            return redirect( route('admin.projets.list') );
        }

    }

    public function projetUpdate(Request $request, $id)
    {

        $projet = Projet::find($id);
        $user = $projet->user;
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
                if($request->entry_date){
                    $projet->created_at = $request->entry_date;
                }


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

                    Flashy::success('Votre projet a été modifié avec succès !');
                    return redirect( route('admin.projets.list') );
                } else {
                    Flashy::error('Le projet n\'a pas été modifié');
                    return redirect( route('admin.projets.list') );
                }

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

    public function parametres()
    {
      $departements = Departement::all();
      $categories = Category::orderBy('name', 'asc')->get();
      $budgets = Budget::all();

      return view('admin.parametres')
      ->with('budgets', $budgets)
      ->with('departements', $departements)
      ->with('categories', $categories);
    }


}
