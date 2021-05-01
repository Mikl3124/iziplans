@extends('layouts.app')

@section('content')
    {{-- -------------- Si l'utilisateur est client --------------- --}}
    @if(Auth::user()->role === 'client')
        <div class="text-center bg-primary py-4 mb-5">
            <h1 class="text-white">MES PROJETS</h1>
        </div>
        <div class="container">
            @foreach ($projets_client as $projet)
            <a href="{{ route('projet.show', $projet) }}">
                <div class="card card-project-home mb-3">

                    <div class="card-body ">
                        <h2 class="list-project-title">{{ $projet->title }}</h2>
                        <div class="row">
                            @if ($projet->status === "open")
                                <span class="col-12 col-sm-6 col-md-3"><i class="fas fa-circle text-success"></i> Ouvert {{Carbon\Carbon::parse($projet->created_at)->diffForHumans()}}</span>
                            @elseif ($projet->status === "closed")
                                <span class="col-12 col-sm-6 col-md-3"><i class="fas fa-circle text-secondary"></i> Fermé le {{Carbon\Carbon::parse($projet->updated_at)->isoFormat('LL')}}</span>
                            @endif
                            <span class="col-12 col-sm-6 col-md-3"><i class="fas fa-map-marker-alt"></i> {{$projet->departement->name}}</span>
                            <span class="col-12 col-sm-6 col-md-3"><i class="fas fa-euro-sign"></i> {{ $projet->budget->name }} </span>
                            <span class="col-12 col-sm-6 col-md-3"><i class="fas fa-gavel"></i> {{ $projet->offers->count()}} {{ $projet->offers->count() <= 1 ? 'Offre' : 'Offres'}} </span>
                        </div>
                        <hr>
                            <p class="card-text">{{ Str::words($projet->description, 45, '...') }}</p>
                        @foreach($projet->categories as $category)
                            <span class="categories">{{ $category->name }} </span>
                        @endforeach
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @elseif(Auth::user()->role === 'freelance')
        {{-- -------------- Si l'utilisateur est freelance --------------- --}}
        <div class="text-center bg-primary py-4 mb-5">
            <h1 class="text-white">MES OFFRES</h1>
        </div>
        <div class="container"> 
            <ul class="list-group">
                @foreach ($offres_freelance as $offer)
                 <a href="{{ route('offers.edit', $offer) }}">
                    <li class="list-group-item">{{ $offer->projet->title }}</li>
                </a>
                @endforeach
            </ul>                
        </div>
    @endif
@endsection
