@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card mt-5">
        <div class="card-body row">
            <div class="col-md-2 col-sm-12 text-center">
                <img class="mr-3 mt-4 rounded profil-avatar" src={{ $avatar }}>

            </div>
            <div class="col-md-8 col-sm-12 my-3 text-center">
                <h2 class="my-auto">{{ $user->firstname }} {{ $user->lastname }}</h2>
            <p><em>Membre depuis le {{Carbon\Carbon::parse($user->created_at)->isoFormat('LL')}}</em></p>
            </div>
            <div class="col-md-2 col-sm-12 my-3 text-center">
                @if ( !empty(Auth::user()) && Auth::user()->id === Auth::user()->id)
                    <a href="{{ route('profil-edit', Auth::user()) }}" class="btn btn-primary">Modifier mon profil</a>
                @endif
            </div>

        </div>

    </div>

</div>

@endsection
