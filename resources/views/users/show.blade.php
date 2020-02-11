@extends('layouts.app')

@section('content')
<div class="container">
    <img class="mr-3 rounded image-avatar" src="{{ Storage::disk('s3')->url(Auth::user()->avatar) }}">
    <h1>{{ $user->firstname }}</h1>
    <a href="{{ route('profil-edit', Auth::user()) }}" class="btn btn-primary">Modifier mon profil</a>
</div>

@endsection