<?php

namespace App\Http\Controllers;

use App\Model\Article;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
  public function index(Request $r)
  {

    $articles = Article::orderBy('id', 'desc')->get();
    return response()->view('sitemap', compact('articles'))
      ->header('Content-Type', 'text/xml');
  }
}
