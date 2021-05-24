<?php

namespace App\Http\Controllers;

use App\Model\Budget;
use App\Model\Projet;
use App\model\Category;
use App\Model\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

     public function list()
    {
        $categories = Category::all();
        $departements = Departement::all();
        $budgets = Budget::all();
        
        $projets_first = Projet::where("status", "=", "open")->orwhere("status", "=", "closed")->orderBy('created_at', 'desc')->take(3)->get();
        $projets_seconds = Projet::where("status", "=", "open")->orwhere("status", "=", "closed")->orderBy('created_at', 'desc')->skip(3)->take(3)->get();

        return view('welcome', compact('projets_first', 'projets_seconds', 'categories', 'departements', 'budgets'));
    }

    public function cgv()
    {
        return view('cgv');
    }

    public function politique()
    {
        return view('politique-de-confidentialite');
    }
}
