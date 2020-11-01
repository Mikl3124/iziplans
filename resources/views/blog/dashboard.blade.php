@extends('layouts.app')

@section('content')
  <div class="container">
    <a class="btn btn-primary mt-5" href={{ route('admin.article.create') }}>Créer un article</a>
    <a class="btn btn-secondary mt-5" href={{ route('admin.blog.category') }}>Gérer les catégories</a>
  </div>

@endsection
