
@extends('layouts.app')

@section('content')

<div class="container">
    <!-- Page Heading -->
  <h1 class="my-4">Le Blog</h1>
  @foreach($articles as $article)
    <div class="row">
      <div class="col-md-7">
        <a href="#">
          <img class="img-fluid rounded mb-3 mb-md-0" src="http://placehold.it/700x300" alt="">
        </a>
      </div>
      <div class="col-md-5">
        <h3>{{$article->title}}</h3>
        <p>{{ $article->intro_text}}</p>
        <a class="btn btn-primary" href="{{ route('article.show', Str::slug($article->title)) }}">Voir l'article</a>
      </div>
    </div>
      <hr>
  @endforeach

  {{ $articles->links() }}
</div>


@endsection
