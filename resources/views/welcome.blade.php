@extends('layouts.app')

@section('content')

   {{-- ----------- Banner ---------- --}}
<div class="banner" style="background-image:url(https://iziplans.s3.eu-west-3.amazonaws.com/images/iziplans-banner.jpg)">
    <div class="container">
        <div class="display-4 text-center text-white">VOS PLANS FACILEMENT</div>
        <blockquote class="blockquote text-center">
            <p class="mb-0">Trouvez le professionnel idéal pour votre projet</p>
        </blockquote>
        @guest
            <div class="row">
                <div class="col-md-6 col-sm-12 mt-5 text-center">
                    <a class="btn btn-primary btn-lg text-center" href="{{ route('register_freelance') }}">Devenir Freelance</a>
                </div>
                <div class="col-md-6 col-sm-12 mt-5 text-center">
                    <a class="btn btn-primary btn-lg " href="{{route('projet.create')}}">Déposer un projet</a>
                </div>
            </div>
        @endguest
        @auth
            @if(Auth::user()->role === 'client')
                <div class="row">
                    <div class="col-md-6 col-sm-12 mt-5 text-center">
                        <a class="btn btn-primary btn-lg text-center" href="{{route('projet.index')}}"></i> Gérer mes projets</a>
                    </div>
                    <div class="col-md-6 col-sm-12 mt-5 text-center">
                        <a class="btn btn-success btn-lg " href="{{route('projet.create')}}"></i> Publier un projet</a>
                    </div>
                </div>
            @endif
        @endauth
    </div>

</div>



</div>
{{-- ----------- Banner ---------- --}}
<div class="container">

    {{-- ----------- Dernières Missions Proposées ---------- --}}

    <div class="text-center">
        <h1 class="text-center mt-5 mb-5 last_missions">Les dernières missions proposées</h1>
    </div>
    {{-- ----------- 3 Derniers Projets ---------- --}}
        @foreach ($projets_first as $projet)
        <a href="{{ route('projet.show', $projet) }}">
            <div class="card card-project-home mb-3">

                <div class="card-body ">
                    <h2 class="list-project-title">{{$projet->title}}</h2>
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
    {{-- ----------- Call to action ---------- --}}
        <div class="card card-pub-home mb-3">
            <div class="card-body ">
                <p class= "title-call-to-action">Besoins de plans ? Déposez une annonce gratuitement</p>
                <p class= "text-call-to-action">Recevez vos premiers devis rapidement</p>
                <a class="btn btn-success btn-lg" href="{{route('projet.create')}}">Recevoir des devis</a>
            </div>
        </div>

    {{-- ----------- 3 Projets Suivants ---------- --}}
        @foreach ($projets_seconds as $projet)
        <a href="{{ route('projet.show', $projet) }}">
            <div class="card card-project-home mb-3">

                <div class="card-body ">
                    <h2 class="list-project-title">{{$projet->title}}</h2>
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
    </ul>
    {{-- ----------- Comment ça marche ? ---------- --}}
<div class="text-center mt-5">
    <h1 class="text-center mb-5">Comment ça marche?</h1>
    <div class="row d-flex justify-content-around">
        <div class="col-lg-3 col-sm-6">
            <div >
                <img src="https://iziplans.s3.eu-west-3.amazonaws.com/images/paper-plane-1.png" class="card-img-iziplans" alt="demande de mission">
                <div class="card-body">
                    <p class="card-text">Postez votre demande de mission gratuitement, pour obtenir vos offres</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div >
                <img src="https://iziplans.s3.eu-west-3.amazonaws.com/images/discuss-issue-1.png" class="card-img-iziplans" alt="propositions de devis">
                <div class="card-body">
                    <p class="card-text">Recevez en moins de 24h, des propositions de prestataires qualifiés</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div >
                <img src="https://iziplans.s3.eu-west-3.amazonaws.com/images/choice-1.png" class="card-img-iziplans" alt="consultez les profils">
                <div class="card-body">
                    <p class="card-text">Consultez librement les profils des prestataires et les avis pour faire votre choix</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div >
                <img src="https://iziplans.s3.eu-west-3.amazonaws.com/images/team-1.png" class="card-img-iziplans" alt="echangez discutez">
                <div class="card-body">
                    <p class="card-text">Echangez, discutez et négociez sans intermédiaire, avec les prestataires de votre choix</p>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- ----------- Comment ça marche ? ---------- --}}
</div>

@endsection

