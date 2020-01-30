@extends('layouts.app')

@section('content')

<div class="container-fluid bg-primary">
    <div class="container py-4">
        <h1 class="text-left pt-5 text-white">{{ucfirst($projet->title)}}</h1>
        <div class="d-flex justify-content-start mb-5 ">
            <p class= "subtitle-project"><span class="mr-1 published project-state"></span> Ouvert</p>
            <p class="subtitle-project mx-3"><span><i class="subtitle-project far fa-eye"></i></span> 15 Vue(s)</p>
            <p class="subtitle-project"><span><i class="subtitle-project fas fa-gavel"></i></span> 8 Offre(s)</p>
            
        </div>
    </div>
</div>
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="card card-show mb-5 col-md-7 col-sm-12 mt-n5">
                <p class="show-description">{{ucfirst($projet->description)}}</p>
                <div>
                    <table class="table table-bordered mb-3">
                        <tbody>
                            <tr>
                                <td scope="row" class="td-show">Publié le</td>
                                <th scope="col">{{Carbon\Carbon::parse($projet->created_at)->isoFormat('LL')}}</td>
                            </tr>
                            <tr>
                                <td scope="row"  class="td-show">Localisation</td>
                                <th scope="col">{{$projet->localisation}}</td>
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
                <div class="card card-show bg-dark mb-3">
                    <p class="text-white">Le client n'a pas encore choisi son prestataire. Dépêchez-vous, il est encore temps de proposer votre devis.</p>
                    @guest
                        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">Faire une offre</button>
                    @endguest
                    @auth
                        <a href="{{route('offers.create', $projet)}}" class="btn btn-success">Faire une offre</a>
                    @endauth
                </div>
                <div class="card">
                <div>
                    <p class="text-white">Le client n'a pas encore choisi son prestataire. Dépêchez-vous, il est encore temps de proposer votre devis.</p>
                    <button class="btn btn-primary">Contacter le client</button>
                </div>
                
            </div>
        </div>    
    </div>

{{-- ------------------------------------------------ Modal ----------------------------------------------- --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

@endsection
