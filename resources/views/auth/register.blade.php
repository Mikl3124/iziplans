@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="text-center">
                            <p><em>Selectionnez votre type de compte</em></p>
                        </div>
                        <div class="d-flex justify-content-around mb-4">
                            <label>
                                <input type="radio" name="role" value="client" checked>
                                <i class="choice-icon fas fa-user-alt"></i>
                            </label>
                            <label>
                                <input type="radio" name="role" value="freelance" checked>
                                <i class="choice-icon fas fa-pencil-ruler"></i>
                            </label>
                            
                        </div>

                          <div class="form-row">
                            <div class="col-md-6 col-sm-12 mb-4">
                            <input id="firstname" placeholder="Prénom" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-sm-12 mb-4">
                            <input id="lastname" placeholder="Nom" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col mb-4">
                                <input id="email" placeholder="E-mail" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 col-sm-12 mb-4">
                                <input id="password" placeholder="Mot de passe" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 col-sm-12 mb-4">
                                <input id="password-confirm" placeholder="Confirmer le mot de passe" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="true" id="gridCheck" @error('cgv') is-invalid @enderror" name="cgv" value="{{ old('cgv') }}" required autocomplete="cgv">
                            @error('cgv')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            <label class="form-check-label" for="gridCheck">
                                Je déclare avoir pris connaissance des <a href="http://">conditions générales de vente</a>
                            </label>
                            </div>
                        </div>

                        <div class="form-group mb-4 text-center">
                            <button type="submit" class="btn btn-primary">
                                S'enregister
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
