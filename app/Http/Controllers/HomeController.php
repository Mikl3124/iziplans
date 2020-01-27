<?php

namespace App\Http\Controllers;

use App\Model\Projet;
use App\model\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $choice_img = Storage::disk('s3')->url('images/choice-1.png');
        $discuss_img = Storage::disk('s3')->url('images/discuss-issue-1.png');
        $plane_img = Storage::disk('s3')->url('images/paper-plane-1.png');
        $team_img = Storage::disk('s3')->url('images/team-1.png');
        $banner_img = Storage::disk('s3')->url('images/iziplans-banner.jpg');
        $projets = Projet::with('categories')->where('status', 'publish')->orderBy('created_at', 'desc')->paginate(5);
        return view('welcome', compact('projets','choice_img','discuss_img','plane_img','team_img', 'banner_img'));
    }
}