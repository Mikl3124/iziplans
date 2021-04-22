<?php

namespace App\Http\Controllers;

use App\Model\Article;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
  public function index(Request $r)
  {

    $posts = Article::orderBy('id', 'desc')->where('post_status', 'Publish')->get();

    return response()->view('sitemap', compact('posts'))
      ->header('Content-Type', 'text/xml');
  }
}
