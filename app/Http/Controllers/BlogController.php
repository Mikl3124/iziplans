<?php

namespace App\Http\Controllers;

use App\Model\Article;
use Illuminate\Support\Str;
use App\Model\Blogcategorie;
use Illuminate\Http\Request;
use App\Model\Categoriesarticle;
use MercurySeries\Flashy\Flashy;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
      return view('blog.dashboard');
    }

    public function categories()
    {
      $categories = Blogcategorie::all();
      return view('blog.categories', compact('categories'));
    }

    public function storeCategories(Request $request)
    {
      $input = $request->all();

      $this->validate($request, [
                'title' => 'required|string|max:255',
                ]);
          $categorie = new Blogcategorie;
          $categorie->title = $request->title;
          $categorie->save();

      return redirect()->back();
    }



    public function index()
    {
      $articles = DB::table('articles')
                ->latest()
                ->paginate(5);


      return view('blog.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Blogcategorie::all();
        return view('blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $input = $request->all();

      $this->validate($request, [
                'categorie' => 'bail|required',
                'title' => 'bail|required|string|max:255',
                'description' => 'bail|required|string',
                'keywords' => 'bail|required|string',
                'article' => 'bail|required|string',
                'file' => 'sometimes|max:5000',
                ]);
      $user = Auth::user();
          $article = new Article;
          $article->user_id = $user->id;
          $article->title = $request->title;
          $article->url = str_slug($request->title);
          $article->keywords = $request->keywords;
          $article->categorie = $request->categorie;
          $article->intro_text = $request->description;
          $article->full_text = $request->article;
          if ($files = $request->file('file')) {
            $filenamewithextension = $request->file('file')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('file')->getClientOriginalExtension();

            //filename to store
            //$path = 'documents/' . $user->lastname. '_' . $user->firstname . '_' . time();

            $filenametostore = $filename.'_'.time().'.'.$extension;

                //Upload File

                Storage::putFileAs('documents', $request->file('file'), $filenametostore );

                //Store $filenametostore in the database
                $article->filename = $filenametostore;
            }
            $article->save();

            Flashy::success('Votre article a été posté avec succès');

            return redirect()->route('blog.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $article = Article::where("url", $url)->first();

        views($article)->record();

        return view('blog.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($url)
    {
        $article = Article::where("url", $url)->first();
        $categories = Blogcategorie::all();
        return view('blog.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $article = Article::find($id);
      $input = $request->all();

      $this->validate($request, [
                'categorie' => 'bail|required',
                'title' => 'bail|required|string|max:255',
                'description' => 'bail|required|string',
                'keywords' => 'bail|required|string',
                'article' => 'bail|required|string',
                'file' => 'sometimes|max:5000',
                ]);
      $user = Auth::user();
          $article->user_id = $user->id;
          $article->title = $request->title;
          $article->url = str_slug($request->title);
          $article->keywords = $request->keywords;
          $article->categorie = $request->categorie;
          $article->intro_text = $request->description;
          $article->full_text = $request->article;
          if ($files = $request->file('file')) {
            $filenamewithextension = $request->file('file')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('file')->getClientOriginalExtension();

            //filename to store
            //$path = 'documents/' . $user->lastname. '_' . $user->firstname . '_' . time();

            $filenametostore = $filename.'_'.time().'.'.$extension;

                //Upload File

                Storage::putFileAs('documents', $request->file('file'), $filenametostore );

                //Store $filenametostore in the database
                $article->filename = $filenametostore;
            }
            $article->save();

            Flashy::success('Votre article a été posté avec succès');

            return redirect()->route('blog.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($url)
    {
        $article = Article::where("url", $url)->first()->delete();
        Flashy::success('Votre article a été supprimé avec succès');
        return redirect()->route('blog.index');
    }
}
