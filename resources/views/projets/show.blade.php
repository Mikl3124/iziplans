@extends('layouts.app')

@section('content')

<div class="container-fluid bg-primary">
    <div class="container py-4">
        <h1 class="text-left pt-5 text-white">{{ucfirst($projet->title)}}</h1>
        <div class="d-flex justify-content-start mb-5 ">
            @if($projet->status === 'open')
                <p class= "subtitle-project"><span class="fas fa-circle text-success"></span> Ouvert {{Carbon\Carbon::parse($projet->created_at)->diffForHumans()}}</p>
            @elseif($projet->status === 'closed')
                <p class= "subtitle-project"><span class="fas fa-circle text-secondary"></span> Fermé le {{Carbon\Carbon::parse($projet->updated_at)->isoFormat('LL')}}</p>
            @endif
            <p class="subtitle-project mx-3"><span><i class="subtitle-project fas fa-gavel"></i></span> {{$offers->count()}} {{ $projet->offers->count() <= 1 ? 'Offre' : 'Offres'}}</p>

        </div>
    </div>
</div>
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="card card-show mb-5 col-md-7 col-sm-12 mt-n5">
                <p class="show-description">{{ucfirst($projet->description)}}</p>
                <div class="mb-4">
                    @isset($projet->file_projet)
                        <a href="{{ route('downloadfile', $projet) }}">
                            <i class="fas fa-download"></i> Télécharger le fichier
                        </a>
                    @endisset
                </div>
                <div>
                    <table class="table table-bordered mb-3">
                        <tbody>
                            <tr>
                                <td scope="row" class="td-show">Publié le</td>
                                <th scope="col">{{Carbon\Carbon::parse($projet->created_at)->isoFormat('LL')}}</td>
                            </tr>
                            <tr>
                                <td scope="row"  class="td-show">Localisation</td>
                                <th scope="col">{{$departement->name}}</td>
                            </tr>
                            <tr>
                                <td scope="row" class="td-show">Budget</td>
                                <th scope="col">{{$projet->budget->name}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div >
{{-- ------------------------------------------------ Right part ----------------------------------------------- --}}
            <div class="col-md-4 my-2 col-sm-12 mt-n5">
                {{-- --------------- Si l'utilisateur est l'auteur du projet --------------- --}}
                @if ( !empty(Auth::user()) && Auth::user()->id === $projet->user->id)
                    <div class="card card-show mb-3">
                        {{-- --------------- Si le projet est publié --------------- --}}
                        @if ($projet->status === 'open')
                            <a href="{{ route('projet.edit', $projet) }}" class="btn btn-primary text-white mb-3"><i class="fas fa-pencil-alt text-white"></i> Modifier mon projet </a>
                            <a data-toggle="modal" data-target="#closeModal" class="btn btn-danger text-white"><i class="fas fa-exclamation-triangle text-white"></i> Fermer mon projet </a>
                        {{-- --------------- Si le projet est fermé --------------- --}}
                        @elseif ($projet->status === 'closed')
                            <a href="{{ route('projet.open', $projet) }}" class="btn btn-success text-white"><i class="fas fa-lock-open text-white"></i> Publier à nouveau le projet</a>
                        @endif
                    </div>
                @else
                {{-- --------------- Si l'utilisateur n'est pas connecté --------------- --}}
                    @guest
                        <div class="card card-show bg-dark mb-3">
                            <p class="text-white">Le client n'a pas encore choisi son prestataire. Dépêchez-vous, il est encore temps de proposer votre devis.</p>
                            <button class="btn btn-success" data-toggle="modal" data-target="#modal">Faire une offre</button>
                        </div>
                    @endguest
                {{-- --------------- Si l'utilisateur est connecté --------------- --}}
                    @auth
                    {{-- --------------- Si c'est un freelance --------------- --}}
                        @if (null !== (Auth::user()) && Auth::user()->role === 'freelance')
                            {{-- --------------- Si le projet est ouvert --------------- --}}
                            @if ($projet->status === 'open')
                                <div class="card card-show bg-dark mb-3">
                                    <p class="text-white">Le client n'a pas encore choisi son prestataire. Dépêchez-vous, il est encore temps de proposer votre devis.</p>
                                    {{-- --------------- Si le freelance n'a pas encore fait d'offre --------------- --}}
                                    @if ($has_make_an_offer === false)
                                        {{-- --------------- Si il est abonné --------------- --}}
                                        @if (null !== (Auth::user()) && Auth::user()->role === 'freelance')
                                            <a href="{{ route('offers.create', $projet)}}" class="btn btn-success">Faire une offre</a>
                                        @else
                                            <a href="{{route('subscribe')}}" class="btn btn-success"> Voir les abonnements </a>
                                        @endif

                                    {{-- --------------- Si le freelance a fait une offre --------------- --}}
                                    @elseif ($has_make_an_offer === true)
                                        <a href="{{route('offers.edit', $freelance_offer)}}" class="btn btn-success">Modifier mon offre</a>
                                    @endif
                            {{-- --------------- Si le projet est fermé --------------- --}}
                            @elseif ($projet->status === 'closed')
                                <div class="card card-show bg-dark mb-3">
                                    <p class="text-white text-center">Ce projet est fermé .</p>
                                    <p class="text-white text-center">Il n'est plus possible de faire d'offre .</p>
                                    <a href="" class="btn btn-success"><i class="fas fa-list text-white"></i> Consulter la liste des projets</a>
                                </div>
                            @endif
                            </div>
                            <div class="card card-show mb-3">
                                {{-- --------------- Si le projet est ouvert --------------- --}}
                                @if ($projet->status === 'open')

                                    <a href="{{ route('messagerie.show', ['projet' => $projet->id, 'topic' =>$topic]) }}" class="btn btn-primary"><i class="fas fa-pen text-white"></i> Contacter le client</a>
                                {{-- --------------- Si le projet est fermé --------------- --}}
                                @elseif ($projet->status === 'closed')
                                    <a href="" class="btn btn-success"><i class="fas fa-list text-white"></i> Consulter la liste des projets</a>
                                @endif
                            </div>
                    {{-- --------------- Si c'est un client --------------- --}}
                        @elseif (!empty(Auth::user()) && Auth::user()->role === 'client')
                            <div class="card card-show bg-dark mb-3">
                                <p class="text-white">Le client n'a pas encore choisi son prestataire. Dépêchez-vous, il est encore temps de proposer votre devis.</p>
                                <button class="btn btn-success" data-toggle="modal" data-target="#modal">Faire une offre</button>
                            </div>
                            <div class="card card-show mb-3">
                                <a href="{{route('messagerie.show', ['projet' => $projet, 'topic' =>$topic])}}" class="btn btn-primary">Déposez un projet également</a>
                            </div>
                        @endif

                    @endauth
                @endif
            </div>
        </div>



         <div class="text-center">
        {{-- --------------- Si il n'y a aucune offre pour ce projet --------------- --}}
            @if($offers->count() === 0)
                @if ( !empty(Auth::user()) && Auth::user()->id === $projet->user->id)
                    <h3>Il n'y a pas encore d'offre pour votre projet</h3>
                @else
                    <h3>Il n'y a pas encore d'offre pour ce projet, soyez le premier !</h3>
                    {{-- --------- Si le Freelance est abonné ---------- --}}
                    @if (null !== (Auth::user()) && Auth::user()->role === 'freelance')
                        <a href="{{ route('offers.create', $projet)}}" class="btn btn-success">Faire une offre</a>
                    @else
                    {{-- --------- Si il n'est pas abonné ---------- --}}
                        <a href="{{route('subscribe')}}" class="btn btn-success"> Voir les abonnements </a>
                    @endif
                @endif
        {{-- --------------- Si il y a des offres pour ce projet --------------- --}}
            @elseif($offers->count() === 1)
                @if ( !empty(Auth::user()) && Auth::user()->id === $projet->user->id)
                    <h3>Seulement une seule offre pour votre projet</h3>
                @else
                    <h3>Il n'y a qu'une seule offre pour ce projet</h3>
                @endif
            @elseif($offers->count() > 1)
                @if ( !empty(Auth::user()) && Auth::user()->id === $projet->user->id)
                    <h3>Il y {{ $offers->count() }} offres pour votre projet</h3>
                @else
                    <h3>Il y {{ $offers->count() }} offres pour ce projet</h3>
                @endif
            @endif

        </div>



{{-- ------------------------------------------------ Offres ----------------------------------------------- --}}
        @foreach ($offers as $offer)
            <div class="card mb-3">
                <div class="card-body">
                    <em class="list-project-time ">Offre postée {{Carbon\Carbon::parse($offer->created_at)->diffForHumans()}}</em>
                    <div class="row align-items-center mt-2">
                        <div class= "col-md-7 col-sm-12">
                            <div class="row">
                                <div class="col-md-2 col-sm-6">
                                    @auth
                                        @if (Auth::user()->avatar === NULL)
                                            <img id="blah" class="mr-3 rounded card-avatar" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/avatar.png">
                                        @else
                                            <img id="blah" class="mr-3 rounded card-avatar" src="{{ Storage::url('/users/medium/'. $offer->user->avatar) }}">
                                        @endif
                                    @endauth
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <p>{{$offer->user->lastname}}</p>
                                    {{$offer->user->firstname}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class="row">
                            {{-- --------- Si l'User est le Freelance qui a fait l'offre ----------- --}}
                                @if (!empty(Auth::user()) && Auth::user()->id === $offer->user->id)

                                    <p class= "col-md-3 col-sm-6 text-center mb-0 pt-1">{{$offer->offer_price}} € TTC</p>
                                    <p class= "col-md-3 col-sm-6 text-center mb-0 pt-1">{{$offer->offer_days}} jours</p>
                                    <a class= "col-md-6 col-sm-12 btn btn-secondary" href="{{route('offers.edit', $freelance_offer)}}">Modifier mon offre</a>
                            {{-- --------- Si l'User est le Client qui a posté l'offre ----------- --}}
                                @elseif ( !empty(Auth::user()) && Auth::user()->id === $projet->user->id)
                                    <p class= "col-md-3 col-sm-6 text-center mb-0 pt-1">{{$offer->offer_price}} € TTC</p>
                                    <p class= "col-md-3 col-sm-6 text-center mb-0 pt-1">{{$offer->offer_days}} jours</p>
                                    <a class= "col-md-6 col-sm-12 btn btn-secondary" href="{{ route('offers.show', $offer->id) }}">Consulter</a>
                                @else
                                    <p class= "col-md-12 text-center"><em><i class="fas fa-lock"></i> Seul le client peut voir cette offre <i class="fas fa-lock"></i></em></p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


{{-- ------------------------------------------------ Modal Delete ----------------------------------------------- --}}
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLongTitle">Votre compte iziplans</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <div class="d-flex flex-column bd-highligh mb-3">
                <p>Pour effectuer cette action vous devez avoir un compte (gratuit) et être identifié sur le site.</p>
                <a class="btn btn-primary my-2" href="{{ route('register_freelance') }}">M'inscrire gratuitement</a>
                <a class="btn btn-secondary my-2" href="{{ route('login') }}">Me connecter</a>
            </div>
      </div>
    </div>
  </div>
</div>

{{-- ------------------------------------------------ Modal Close ----------------------------------------------- --}}
<div class="modal fade" id="closeModal" tabindex="-1" role="dialog" aria-labelledby="closeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="closeModalLabel">ATTENTION !</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            Etes-vous sûr de vouloir fermer votre projet?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            <form action="{{route('projet.close')}}" method="post">
                @csrf
            <input type="hidden" name="projet_id" value="{{ $projet->id }}">
                <button type="submit" class="btn btn-danger">Fermer le Projet</button>
            </form>
        </div>
      </div>
    </div>
  </div>

@endsection
