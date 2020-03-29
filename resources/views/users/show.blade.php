@extends('layouts.app')

@section('content')
<div class="container-fluid bg-primary">
    <div class="container py-4">
        @if($user->pseudo)
            <h1 class="text-left pt-5 text-white">{{ ucfirst($user->pseudo) }}</h1>
        @else
            <h1 class="text-left pt-5 text-white">{{ ucfirst($user->firstname) }} {{ ucfirst($user->lastname) }}</h1>
        @endif
        <div class="d-flex justify-content-start mb-5 ">
        <p>{{ ucfirst($user->titre) }}</p>
        </div>
    </div>
</div>
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-md-4 my-2 col-sm-12 mt-n5">
                <div class="card card-show">
                    <div class="card card-show bg-dark mb-3">
                        <img class="rounded profil-avatar my-auto mx-auto" src={{ $user->avatar }}>
                    </div>
                </div>
            </div>
            <div class="card card-show mb-5 col-md-7 col-sm-12 mt-n5">
                <div class="row">
                    <div class="col-md-6 col-sm-12 text-center">
                        <p><em>Membre depuis le {{Carbon\Carbon::parse($user->created_at)->isoFormat('LL')}}</em></p>
                    </div>
                    <div class="col-md-6 col-sm-12 text-center">
                        @if ( !empty(Auth::user()) && Auth::user()->id === Auth::user()->id)
                            <a href="{{ route('profil-edit', Auth::user()) }}" class="btn btn-success">Modifier mon profil</a>
                        @else
                            <a href="{{ route('register_client', Auth::user()) }}" class="btn btn-success">Demander un devis</a>
                        @endif
                    </div>

                </div>
                
                <div class="mb-4">

                </div>
                <div>
                    <p>{!! nl2br(e($user->presentation)) !!}</p></p>
                </div>
            </div >
           


@endsection
