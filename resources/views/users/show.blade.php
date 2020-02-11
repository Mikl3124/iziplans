@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="d-flex col-md-9">
            @if (Auth::user()->avatar === NULL)
                <img class="mr-3 mt-4 rounded profil-avatar" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/avatar.png">
            @else
                <img class="mr-3 mt-4 rounded profil-avatar" src="{{ Storage::disk('s3')->url('/users/'. $user->firstname . '_' . $user->lastname . '/normal/'. $user->avatar) }}">
            @endif
            <h1 class="my-auto">{{ $user->firstname }} {{ $user->firstname }}</h1>
        </div>
        <div class="col-md-3 my-auto">
            @if ( !empty(Auth::user()) && Auth::user()->id === $user->id)
                <a href="{{ route('profil-edit', Auth::user()) }}" class="btn btn-primary">Modifier mon profil</a>
            @endif
        </div>

    </div>
    

    
</div>

@endsection