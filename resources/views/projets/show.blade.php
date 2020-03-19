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
            <p class="subtitle-project mx-3"><span><i class="subtitle-project fas fa-gavel"></i></span> {{$offers->count()}} Offre(s)</p>
            
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
                                <th scope="col">{{$projet->budget}}</td>
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
                        <button class="btn btn-primary mb-4"><i class="fas fa-pencil-alt text-white"></i> Modifier mon projet</button>
                        {{-- --------------- Si le projet est publié --------------- --}}
                        @if ($projet->status === 'open')
                            <a data-toggle="modal" data-target="#closeModal" class="btn btn-danger text-white"><i class="fas fa-exclamation-triangle text-white"></i> Fermer mon projet </a>
                        {{-- --------------- Si le projet est fermé --------------- --}}
                        @elseif ($projet->status === 'closed')
                            <a href={{ route('projet.open', $projet) }}" class="btn btn-success text-white"><i class="fas fa-lock-open text-white"></i> Publier à nouveau le projet</a>
                        @endif                         
                    </div> 
                @else
                {{-- --------------- Si l'utilisateur n'est pas connecté --------------- --}}
                    @guest
                        <div class="card card-show bg-dark mb-3">
                            <p class="text-white">Le client n'a pas encore choisi son prestataire. Dépêchez-vous, il est encore temps de proposer votre devis.</p>
                            <button class="btn btn-success" data-toggle="modal" data-target="#modal">Faire une offre</button>
                        </div>
                        <div class="card card-show mb-3">
                            <button class="btn btn-primary">Contacter le client</button>
                        </div>
                    @endguest
                {{-- --------------- Si l'utilisateur est connecté --------------- --}}
                    @auth
                    {{-- --------------- Si c'est un freelance --------------- --}}
                        @if (!empty(Auth::user()) && Auth::user()->role === 'freelance')
                            <div class="card card-show bg-dark mb-3">
                                <p class="text-white">Le client n'a pas encore choisi son prestataire. Dépêchez-vous, il est encore temps de proposer votre devis.</p>
                                {{-- --------------- Si le freelance n'a pas encore fait d'offre --------------- --}}
                                @if ($has_make_an_offer === false)
                                    <a href="{{route('offers.create', $projet)}}" class="btn btn-success"><i class="fas fa-gavel text-white"></i> Faire une offre</a>
                                {{-- --------------- Si le freelance a fait une offre --------------- --}}
                                @elseif ($has_make_an_offer === true)
                                    <a href="{{route('offers.edit', $freelance_offer)}}" class="btn btn-success">Modifier mon offre</a>                                
                                @endif
                            </div>
                            <div class="card card-show mb-3">
                                <a href="{{route('messagerie.show', ['projet' => $projet, 'topic' =>$topic])}}" class="btn btn-primary"><i class="fas fa-pen text-white"></i> Contacter le client</a>
                            </div>
                    {{-- --------------- Si c'est un client --------------- --}}
                        @elseif (!empty(Auth::user()) && Auth::user()->role === 'client')
                            <div class="card card-show bg-dark mb-3">
                                <p class="text-white">Le client n'a pas encore choisi son prestataire. Dépêchez-vous, il est encore temps de proposer votre devis.</p>
                                <a href="{{route('offers.create', $projet)}}" class="btn btn-success">Faire une offre</a>
                            </div>
                            <div class="card card-show mb-3">
                                <a href="{{route('messagerie.show', ['projet' => $projet, 'topic' =>$topic])}}" class="btn btn-primary">Contacter le client</a>
                            </div>
                        @endif
                        
                    @endauth
                @endif
            </div>
        </div>    
    
{{-- ------------------------------------------------ Offres ----------------------------------------------- --}}
        @foreach ($offers as $offer)
            <div class="card mb-3">
                
                <div class="card-body">
                    <em class="list-project-time ">Offre réalisée le {{Carbon\Carbon::parse($offer->created_at)->diffForHumans()}}</em>
                    <div class="row align-items-center mt-2">
                        <div class= "col-md-8 ">
                            <div class="d-flex justify-content-start">
                            @auth
                                @if (Auth::user()->avatar === NULL)
                                    <img id="blah" class="mr-3 rounded card-avatar" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/avatar.png">
                                @else
                                    <img id="blah" class="mr-3 rounded card-avatar" src="{{ Storage::disk('s3')->url('/users/medium/'. $offer->user->avatar) }}">
                                @endif
                            @endauth
                                <div>
                                    <p>{{$offer->user->lastname}}</p>
                                    {{$offer->user->firstname}}
                                </div>
                                
                            </div>
                            
                        </div>
                        @if (!empty(Auth::user()) && Auth::user()->id === $offer->user->id)
                            <div class= "col-md-4 ">
                                <div class= "d-flex">
                                    <p class= "mr-4">{{$offer->offer_price}} € TTC</p>
                                    <p>{{$offer->offer_days}} jours</p>
                                </div>
                                <a class="btn btn-primary" href="http://">Modifier mon offre</a>
                                
                            </div>
                        @elseif ( !empty(Auth::user()) && Auth::user()->id === $projet->user->id)
                            <p class= "mr-4">{{$offer->offer_price}} € TTC</p>
                            <p>{{$offer->offer_days}} jours</p>
                        @else
                        <p><i class="fas fa-lock"></i> <em>Seul le client peut voir cette offre</em></p>

                        @endif
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
                <a class="btn btn-primary my-2" href="{{ route('register') }}">M'inscrire gratuitement</a>
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
