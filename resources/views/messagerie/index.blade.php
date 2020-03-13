@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class=text-center>Liste des messages</h1>
          <ul>
          @foreach ($topics as $topic)
          <li><a href=""{{ route('messagerie.show', Auth::user()->id) }}">{{ $topic->title }}</a></li>

          @endforeach
          </ul>

    </div>

@endsection
