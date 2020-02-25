@extends('layouts.app')

@section('content')

   {{-- ----------- Banner ---------- --}}
<div class="banner" style="background-image:url(https://iziplans.s3.eu-west-3.amazonaws.com/images/iziplans-banner.jpg)">
    <div class="container">
        <div class="display-4 text-center text-white">VOS PLANS FACILEMENT</div>
        <blockquote class="blockquote text-center">
            <p class="mb-0">Trouvez le professionnel idéal pour votre projet</p>
        </blockquote>
        <div class="input-group">
            <input type="text" class="form-control" placeholder=" Votre recherche...">
            <div class="input-group-append">
              <button class="btn btn-secondary" type="button">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
        <div class="row">
            <div class="col-md-6 col-sm-12 mt-5 text-center">
                <a class="btn btn-primary btn-lg text-center" href="#">Devenir Freelance</a>
            </div>
            <div class="col-md-6 col-sm-12 mt-5 text-center">
                <a class="btn btn-primary btn-lg " href="{{route('projets.create')}}">Déposer un projet</a>
            </div>
        </div>
    </div>

</div>



</div>
{{-- ----------- Banner ---------- --}}
<div class="container">
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

    {{-- ----------- Dernières Missions Proposées ---------- --}}

    <div class="text-center">
        <h1 class="text-center mt-5 mb-5">Les dernières missions proposées</h1>
    </div>
        @foreach ($projets as $projet)
        <a href="/projets/{{ $projet->id }}">
            <div class="card card-project-home mb-3">

                <div class="card-body ">
                    <div class="d-flex">
                        <h2 class="list-project-title">{{$projet->title}} <em class="list-project-time">Posté {{Carbon\Carbon::parse($projet->created_at)->diffForHumans()}}</em></h2>

                    </div>
                    <div class="d-flex justify-content-around">

                        <small>{{$projet->departement->name}}</small>
                        <small>Budget :  801€ à 2500€ </small>
                        <small>{{ $projet->offers->count()}} Offres </small>
                    </div>
                    <hr>

                    <p class="card-text">{{$projet->description}}</p>

                    @foreach($projet->categories as $category)
                        <span class="categories">{{ $category->name }} </span>
                    @endforeach
                    <hr>
                    @foreach($projet->competences as $competence)
                        <span class="categories">{{ $competence->name }} </span>
                    @endforeach

                </div>
            </div>
        </a>
        @endforeach
    </ul>
    <div class="row d-flex justify-content-center">
    </div>
</div>

@endsection

