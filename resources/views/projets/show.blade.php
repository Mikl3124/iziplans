@extends('layouts.app')

@section('content')
<div class="container-fluid bg-primary">
    <div class="container py-4">
        <h1 class="text-left pt-5 text-white">{{ucfirst($projet->title)}}</h1>
        <div class="row d-flex justify-content-start mb-5 ">
            @if($projet->status === 'open')
                <p class= "subtitle-project col-12"><span class="fas fa-circle text-success"></span> Ouvert {{ Carbon\Carbon::parse($projet->created_at)->diffForHumans() }}</p>
            @elseif($projet->status === 'closed')
                <p class= "subtitle-project col-12"><span class="fas fa-circle text-secondary"></span> Fermé le {{ Carbon\Carbon::parse($projet->updated_at)->isoFormat('LL') }}</p>
            @endif
            <p class="subtitle-project mx-3"><span><i class="subtitle-project fas fa-gavel"></i></span> {{$offers->count()}} {{ $projet->offers->count() <= 1 ? 'Offre' : 'Offres'}}</p>
            <p class="subtitle-project mx-3"><i class="subtitle-project fas fa-eye"></i> {{ views($projet)->unique()->count() }} {{views($projet)->unique()->count() === 1 ? 'Vue' : 'Vues'}}</span></p>
        </div>
    </div>
</div>
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="card card-show mb-5 col-md-7 col-sm-12 mt-n5">
                <p class="show-description">{{ ucfirst($projet->description )}}</p>
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
                            <tr>
                                <td scope="row" class="td-show">Auteur</td>
                                {{-- ----- Si le User est  abonné---- --}}
                                @if(Auth::user() && Auth::user()->subscribed('abonnement'))
                                <th scope="col"><a href="{{ route('profil', $projet->user)}}">{{ $projet->user->firstname }} {{ $projet->user->lastname }}</a></td>
                                {{-- ----- Si le User n'est pas abonnée ---- --}}
                                @else
                                <th scope="col"><span><small><em>(visible pour les abonnés)</em></small></span></td>
                                @endif

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div >


{{-- ------------------------------------------------ Right part ----------------------------------------------- --}}

{{-- -------------------------------------------------------------------------------------------------------------------------- --}}
{{-- ------------------------------------------------ AUTH ------------------------------------------------------------- --}}
{{-- -------------------------------------------------------------------------------------------------------------------------- --}}
            @auth
            {{-- -------------- Si Auth est le PROPRIETAIRE de l'offre ------------ --}}
                @if ( !empty(Auth::user()) && Auth::user()->id === $projet->user->id)
                    <div class="col-md-4 my-2 col-sm-12 mt-n5">
                        <div class="card card-show mb-3">
                            <div class="card card-show bg-dark mb-3">
                                <p class="text-white text-center">Vous êtes le propriétaire de ce projet</p>
                                {{-- --------------- Si le projet est OUVERT --------------- --}}
                                @if ($projet->status === 'open')
                                    <a href="{{ route('projet.edit', $projet) }}" class="btn btn-primary text-white mb-3"><i class="fas fa-pencil-alt text-white"></i> Modifier mon projet </a>
                                    <a data-toggle="modal" data-target="#closeModal" class="btn btn-danger text-white"><i class="fas fa-exclamation-triangle text-white"></i> Fermer mon projet </a>
                                {{-- --------------- Si le projet est FERME --------------- --}}
                                @elseif ($projet->status === 'closed')
                                    <a href="{{ route('projet.open', $projet) }}" class="btn btn-success text-white"><i class="fas fa-lock-open"></i> Publier à nouveau le projet</a>
                                @elseif ($projet->status === 'pending')
                                    <p class="text-white text-center">"En cours de validation"</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    {{-- --------------- Si le projet est OUVERT --------------- --}}
                    @if ($projet->status === 'open')
                        {{-- ----- Si c'est un FREELANCE ---- --}}
                            {{-- ---------------- A déjà fait une offre --------------- --}}
                        @if($already_make_a_bid)
                            <div class="col-md-4 my-2 col-sm-12 mt-n5">
                                <div class="card card-show mb-3">
                                    <div class="card card-show bg-dark mb-3">
                                        <p class="text-white">Vous avez déjà fait une offre pour ce projet</p>
                                        {{-- ----- Si le freelance est abonné ---- --}}
                                        @if(Auth::user()->subscribed('abonnement'))
                                            <a href="{{route('offers.edit', $already_make_a_bid->id)}}" class="btn btn-success"> Modifier mon offre </a>
                                        {{-- ----- Si le freelance n'est pas abonné ---- --}}
                                        @else
                                            <a href="{{ route('offers.create', $projet) }}" class="btn btn-success"> Voir les abonnements </a>
                                        @endif
                                    </div>
                                    <div class="card card-show mb-3">
                                        <a href="{{ route('messagerie.show', ['projet' => $projet->id, 'topic' =>$topic]) }}" class="btn btn-primary">Contacter le client</a>
                                    </div>
                                </div>
                            </div>
                            {{-- ---------------- N'a pas fait une offre --------------- --}}
                        @else
                            @if(Auth::user()->role === 'freelance')
                                    <div class="col-md-4 my-2 col-sm-12 mt-n5">
                                        <div class="card card-show mb-3">
                                            <div class="card card-show bg-dark mb-3">

</p>
                                                {{-- ----- Si le freelance est abonné ---- --}}
                                                @if(Auth::user()->subscribed('abonnement'))
                                                    <p class="text-white">Le projet est ouvert, et donc encore d'actualité. Il n'est pas trop tard pour proposer vos services.</p>
                                                    <a href="{{ route('offers.create', $projet) }}" class="btn btn-success"> Faire une offre </a>
                                                {{-- ----- Si le freelance n'est pas abonné ---- --}}
                                                @else
                                                    <p class="text-white">Abonnez-vous pour répondre aux projets, discuter avec le client, et envoyer vos offres.
                                                    <a href="{{ route('offers.create', $projet) }}" class="btn btn-success"> Voir les abonnements </a>
                                                @endif
                                            </div>

                                            <div class="card card-show mb-3">
                                                <a href="{{ route('messagerie.show', ['projet' => $projet->id, 'topic' =>$topic]) }}" class="btn btn-primary">Contacter le client</a>
                                            </div>
                                        </div>
                                    </div>
                                {{-- ----- Si c'est un CLIENT ---- --}}
                                @elseif(Auth::user()->role === 'client')
                                    <div class="col-md-4 my-2 col-sm-12 mt-n5">
                                        <div class="card card-show mb-3">
                                            <div class="card card-show bg-dark mb-3 text-center">
                                                <p class="text-white">Publiez le votre, et recevez des offres GRATUITEMENT</p>
                                                <a href="{{ route('projet.create') }}" class="btn btn-success"> Publier mon projet </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                        @endif
                    {{-- --------------- Si le projet est FERME --------------- --}}
                    @elseif ($projet->status === 'closed')
                        @if(Auth::user()->role === 'freelance')
                            <div class="col-md-4 my-2 col-sm-12 mt-n5">
                                <div class="card card-show mb-3 text-center">
                                    <div class="card card-show bg-dark mb-3">
                                        <p class="text-white">Ce projet est fermé.</p>
                                        <p class="text-white">Consultez toutes les offres</p>
                                        <a href="{{ route('projet.index') }}" class="btn btn-success"> Voir la liste </a>
                                    </div>
                                </div>
                            </div>
                        @elseif(Auth::user()->role === 'client')
                            <div class="col-md-4 my-2 col-sm-12 mt-n5">
                                <div class="card card-show mb-3">
                                    <div class="card card-show bg-dark mb-3 text-center">
                                        <p class="text-white">Ce projet est fermé.</p>
                                        <p class="text-white">Publiez le votre projet, et recevez des offres GRATUITEMENT</p>
                                        <a href="{{ route('projet.create') }}" class="btn btn-success"> Déposer un projet </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                @endif
            @endauth

{{-- -------------------------------------------------------------------------------------------------------------------------- --}}
{{-- ------------------------------------------------ GUEST ------------------------------------------------------------- --}}
{{-- -------------------------------------------------------------------------------------------------------------------------- --}}
            @guest
                <div class="col-md-4 my-2 col-sm-12 mt-n5">
                    <div class="card card-show mb-3">
                        <div class="card card-show bg-dark mb-3">
                            <p class="text-white">Le projet est ouvert, et donc encore d'actualité. Il n'est pas trop tard pour proposer vos services.</p>
                            <button class="btn btn-success" data-toggle="modal" data-target="#modal">Faire une offre</button>
                        </div>
                        <div class="card card-show mb-3">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#modal"> Contacter le client</a>
                        </div>
                    </div>
                </div>
            @endguest
        </div>



{{-- -------------------------- Section Listing offres ----------------------------------------------- --}}


        <div class="text-center">
{{-- -------------------------------------------------------------------------------------------------------------------------- --}}
{{-- ------------------------------------------------ AUTH ------------------------------------------------------------- --}}
{{-- -------------------------------------------------------------------------------------------------------------------------- --}}
            @auth
                {{-- -------------- Si Auth est le PROPRIETAIRE de l'offre ------------ --}}
                @if ( Auth::user()->id === $projet->user->id)
                    @if($offers->count() === 0)
                        <h3>Il n'y a aucune offre pour votre projet</h3>
                    @elseif($offers->count() === 1)
                        <h3>Il n'y a qu'une offre pour votre projet</h3>
                    @elseif($offers->count() > 1)
                        <h3>Il n'y a {{ $offers->count() }} offres pour votre projet</h3>
                    @endif
                @else
                {{-- -------------- Si Auth est le PAS LE PROPRIETAIRE de l'offre ------------ --}}
                    {{-- ----- Si c'est un FREELANCE ---- --}}
                    @if(Auth::user()->role === 'freelance')
                    {{-- ----- Si le freelance est ABONNE---- --}}
                        {{-- ----- Si il a déjà fait une offre---- --}}
                        @if($already_make_a_bid)
                            @if(Auth::user()->subscribed('abonnement'))
                                @if($offers->count() === 0)
                                    <h3>Il n'y a aucune offre pour ce projet, soyez le premier !</h3>
                                    <a href="{{route('offers.edit', $freelance_offer)}}" class="btn btn-success"> Modifier mon offre </a>
                                @elseif($offers->count() === 1)
                                    <h3>Il n'y a qu'une offre pour ce projet, profitez-en !</h3>
                                    <a href="{{route('offers.edit', $freelance_offer)}}" class="btn btn-success"> Modifier mon offre </a>
                                @elseif($offers->count() > 1)
                                    <h3>Il y a {{ $offers->count() }} offres pour ce projet.</h3>
                                    <a href="{{route('offers.edit', $freelance_offer)}}" class="btn btn-success"> Modifier mon offre </a>
                                @endif
                            {{-- ----- Si le freelance n'est PAS ABONNE ---- --}}
                            @elseif(Auth::user()->subscribed('abonnement'))
                                @if($offers->count() === 0)
                                    <h3>Il n'y a aucune offre pour ce projet, soyez le premier !</h3>
                                    <a href="{{route('offers.edit', $freelance_offer)}}" class="btn btn-success"> Modifier mon offre </a>
                                @elseif($offers->count() === 1)
                                    <h3>Il n'y a qu'une offre pour ce projet, profitez-en !</h3>
                                    <a href="{{route('offers.edit', $freelance_offer)}}" class="btn btn-success"> Modifier mon offre </a>
                                @elseif($offers->count() > 1)
                                    <h3>Il y a {{ $offers->count() }} offres pour ce projet.</h3>
                                    <a href="{{route('offers.edit', $freelance_offer)}}" class="btn btn-success"> Modifier mon offre </a>
                                @endif
                            @endif
                        {{-- ----- Si il n'a pas fait d'offre ---- --}}
                        @else
                            @if(Auth::user()->subscribed('abonnement'))
                                @if($offers->count() === 0)
                                    <h3>Il n'y a aucune offre pour ce projet, soyez le premier !</h3>
                                    <a href="{{ route('offers.create', $projet) }}" class="btn btn-success"> Faire une offre </a>
                                @elseif($offers->count() === 1)
                                    <h3>Il n'y a qu'une offre pour ce projet, profitez-en !</h3>
                                    <a href="{{ route('offers.create', $projet) }}" class="btn btn-success"> Faire une offre </a>
                                @elseif($offers->count() > 1)
                                    <h3>Il y a {{ $offers->count() }} offres pour ce projet.</h3>
                                    <a href="{{ route('offers.create', $projet) }}" class="btn btn-success"> Faire une offre </a>
                                @endif
                            {{-- ----- Si le freelance n'est PAS ABONNE ---- --}}
                            @elseif(Auth::user()->subscribed('abonnement'))
                                @if($offers->count() === 0)
                                    <h3>Il n'y a aucune offre pour ce projet, soyez le premier !</h3>
                                    <a href="{{ route('offers.create', $projet) }}" class="btn btn-success"> Voir les abonnements </a>
                                @elseif($offers->count() === 1)
                                    <h3>Il n'y a qu'une offre pour ce projet, profitez-en !</h3>
                                    <a href="{{ route('offers.create', $projet) }}" class="btn btn-success"> Voir les abonnements </a>
                                @elseif($offers->count() > 1)
                                    <h3>Il y a {{ $offers->count() }} offres pour ce projet.</h3>
                                    <a href="{{ route('offers.create', $projet) }}" class="btn btn-success"> Voir les abonnements </a>
                                @endif
                            @endif

                        @endif
                    {{-- ----- Si c'est un CLIENT ---- --}}
                    @elseif(Auth::user()->role === 'client')
                        @if($offers->count() === 0)
                            <h3>Il n'y a aucune offre pour ce projet. Publiez la votre.</h3>
                            <a href="{{ route('projet.create') }}" class="btn btn-success"> Publiez un projet </a>
                        @elseif($offers->count() === 1)
                            <h3>Il n'y a qu'une offre pour ce projet. Publiez la votre.</h3>
                            <a href="{{ route('projet.create') }}" class="btn btn-success"> Publiez un projet </a>
                        @elseif($offers->count() > 1)
                            <h3>Il y a {{ $offers->count() }} offres pour ce projet. Publiez la votre.</h3>
                            <a href="{{ route('projet.create') }}" class="btn btn-success"> Publiez un projet </a>
                        @endif
                    @endif
                @endif
            @endauth
      {{-- -------------------------------------------------------------------------------------------------------------------------- --}}
{{-- ------------------------------------------------ GUEST ------------------------------------------------------------- --}}
{{-- -------------------------------------------------------------------------------------------------------------------------- --}}
            @guest
                @if($offers->count() === 0)
                    <h3>Il n'y a aucune offre pour ce projet, soyez le premier !</h3>
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal">Faire une offre</button>
                @elseif($offers->count() === 1)
                    <h3>Il n'y a qu'une offre pour ce projet, profitez-en !</h3>
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal">Faire une offre</button>
                @elseif($offers->count() > 1)
                    <h3>Il y a {{ $offers->count() }} offres pour ce projet.</h3>
                    <button class="btn btn-success" data-toggle="modal" data-target="#modal">Faire une offre</button>
                @endif
            @endguest

        </div>

{{-- ------------------------------------------------ Offres ----------------------------------------------- --}}
        @foreach ($offers as $offer)
            <div class="card my-3">
                <div class="card-body card-offer mb-3">
                    <em class="list-project-time ">Offre postée {{Carbon\Carbon::parse($offer->created_at)->diffForHumans()}}</em>
                    <div class="row align-items-center mt-2">
                        <div class= "col-md-7 col-sm-12">
                            <div class="row">
                                <div class="col-md-2 col-sm-6">
                                    <div class="item">
                                        @if ($offer->user->updated_profil === 1)
                                            <span class="notify-badge"><img class="verified-user" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/verified.png" alt="utilsateur vérifié"></span>
                                        @endif
                                        <img class="card-avatar" src="{{ $offer->user->avatar }}" alt="freelance avatar">
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                <a href="{{ route('profil', $offer->user->id)}}">
                                    @if($offer->user->pseudo)
                                        <h4 class="mb-0">{{ $offer->user->pseudo }}</h4>
                                    @else
                                        <h4 class="mb-0">{{ $offer->user->firstname }} {{$offer->user->lastname}}</h4>
                                    @endif

                                    @if($offer->user->titre)
                                        <p class="mb-1"><em>{{ $offer->user->titre }}</em></p>
                                    @endif
                                    @if($offer->user->town)
                                        <small>{{ $offer->user->town }}</small>
                                    @endif
                                    @if($offer->user->departement)
                                        <small>({{ ($offer->user->departement) }})</small>
                                    @endif

                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <div class="row">
                            {{-- --------- Si l'User est le Freelance qui a fait l'offre ----------- --}}
                                @if (!empty(Auth::user()) && Auth::user()->id === $offer->user->id)

                                    <p class= "col-md-3 col-sm-6 text-center mb-0 pt-1">{{$offer->offer_price}} € TTC</p>
                                    <p class= "col-md-3 col-sm-6 text-center mb-0 pt-1">{{$offer->offer_days}} jours</p>
                                    <a class= "col-md-5 col-sm-12 btn btn-secondary" href="{{route('offers.edit', $freelance_offer)}}">Modifier mon offre</a>
                            {{-- --------- Si l'User est le Client qui a posté l'offre ----------- --}}
                                @elseif ( !empty(Auth::user()) && Auth::user()->id === $projet->user->id)
                                    <p class= "col-md-3 col-sm-6 text-center mb-0 pt-1">{{$offer->offer_price}} € TTC</p>
                                    <p class= "col-md-3 col-sm-6 text-center mb-0 pt-1">{{$offer->offer_days}} jours</p>
                                    <a class= "col-md-5 col-sm-12 btn btn-secondary" href="{{ route('offers.show', $offer->id) }}">Consulter</a>
                                @else
                                    <p class= "col-md-12 text-center"><em><i class="fas fa-lock"></i> Seul le client peut voir cette offre <i class="fas fa-lock"></i></em></p>
                                @endif
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
