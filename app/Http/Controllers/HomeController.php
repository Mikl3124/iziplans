<?php

namespace App\Http\Controllers;

use App\Model\Projet;
use App\model\Category;
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
            
        $projets = Projet::with('categories')->where('status', 'publish')->orderBy('created_at', 'desc')->paginate(5);

        return view('welcome', compact('projets',));
    }
}