<?php

namespace App\Http\Controllers;

use App\Model\Projet;
use App\Model\Category;
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

        $projets_first = Projet::orderBy('created_at', 'desc')->take(3)->get();
        $projets_seconds = Projet::orderBy('created_at', 'desc')->skip(3)->take(3)->get();

        return view('welcome', compact('projets_first', 'projets_seconds'));
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
