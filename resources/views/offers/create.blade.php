@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{$projet->title}}</h1>
    <h5>Mon offre pour ce projet</h5>
        <div class="row d-flex justify-content-between">
            <div class="card card-show mb-5 col-md-7 col-sm-12 mt-n5">
                <form action="{{ route('offers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                <input type="hidden" name="projet_id" value="{{$projet->id}}">
                    <div class="form-group">
                        <div class="form-row align-items-center">
                            <div class="col-md-6 col-sm-6 my-1">
                                <label class="" for="offer_price">Mon offre</label>
                                <div class="input-group">
                                    <input type="text" name="offer_price" class="form-control @error('offer_price') is-invalid @enderror" value="{{ old('offer_price') }}" id="offer_price">
                                    
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">€</div>
                                    </div>
                                    @error('offer_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 my-1">
                                <label class="" for="offer_days">Durée de réalisation</label>
                                <div class="input-group">
                                    <input type="text" name="offer_days" class="form-control @error('offer_days') is-invalid @enderror" value="{{ old('offer_days') }}" id="offer_days">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">jours</div>
                                    </div>
                                    @error('offer_days')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12 my-1 text-private">
                            <div class="form-group ">
                                <label for="offer_message">Message privé</label>
                                <textarea class="form-control @error('offer_message') is-invalid @enderror" " name="offer_message" id="offer_message" rows="5">{{ old('offer_message') }}</textarea>
                                @error('offer_message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group ">
                            <div class="custom-file">
                              <input type="file" name="filename" class="custom-file-input" id="customFile">
                              <label class="custom-file-label" for="customFile">Joindre un fichier</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Envoyer</button>
                        </div>
                        
                    </div>
                </form>
            </div>
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

</div>

<script>
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    </script>

@endsection