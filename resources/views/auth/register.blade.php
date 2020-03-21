@extends('layouts.app_without_navbar')

@section('content')
<div class="container">
    <div class="text-center my-5">
        <h2 >Bienvenue sur <a href="{{route('home')}}"><img src="https://iziplans.s3.eu-west-3.amazonaws.com/images/iziplans-logo.png" id="logo-iziplans" alt="logo-iziplans"></a></h2>
    </div>
    <div class="card-block">
        <div class="text-center">
            <p>Créez un compte rapidement :</p>
            <div class="row justify-content-md-center">
                {{-- ---------------- Social connection ---------------- --}}
                <a href="{{route('social-login.redirect', 'twitter', $role)}}" class="btn btn-secondary ml-2">Login with Twitter</a>
                <a href="{{route('social-login.redirect', 'github', $role)}}" class="btn btn-secondary ml-2">Login with Github</a>
                <a href="{{route('social-login.redirect', 'facebook', $role)}}" class="btn btn-secondary ml-2">Login with Facebook</a>
                <a href="{{route('social-login.redirect', 'google', $role)}}" class="btn btn-secondary ml-2">Login with Google</a>
                <a href="{{route('social-login.redirect', 'linkedin', $role)}}" class="btn btn-secondary ml-2">Login with Linkedin</a>
            </div>
        </div>
        <form method="POST" action="{{ route('register', $role) }}">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mt-5">
                        <div class="card-body">
                            <div class=text-center>
                                <p>Créez un compte avec votre adresse email :</p>
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
                                    <div class="input-group" id="show_hide_password_1">
                                        <input id="password" placeholder="Mot de passe" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>   
                                </div>
                                <div class="col-md-6 col-sm-12 mb-4">
                                    <div class="input-group" id="show_hide_password_2">
                                        <input id="password-confirm" placeholder="Confirmer le mot de passe" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                                        </div>
                                    </div>
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
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        S'enregister
                                    </button>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <p>Déjà inscrit sur iziplans ?<a href="{{ route('login') }}">Connectez-vous</a></p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

$(document).ready(function() {
    $("#show_hide_password_1 a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password_1 input').attr("type") == "text"){
            $('#show_hide_password_1 input').attr('type', 'password');
            $('#show_hide_password_1 i').addClass( "fa-eye-slash" );
            $('#show_hide_password_1 i').removeClass( "fa-eye" );
        }else if($('#show_hide_password_1 input').attr("type") == "password"){
            $('#show_hide_password_1 input').attr('type', 'text');
            $('#show_hide_password_1 i').removeClass( "fa-eye-slash" );
            $('#show_hide_password_1 i').addClass( "fa-eye" );
        }
    });
    $("#show_hide_password_2 a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password_2 input').attr("type") == "text"){
            $('#show_hide_password_2 input').attr('type', 'password');
            $('#show_hide_password_2 i').addClass( "fa-eye-slash" );
            $('#show_hide_password_2 i').removeClass( "fa-eye" );
        }else if($('#show_hide_password_2 input').attr("type") == "password"){
            $('#show_hide_password_2 input').attr('type', 'text');
            $('#show_hide_password_2 i').removeClass( "fa-eye-slash" );
            $('#show_hide_password_2 i').addClass( "fa-eye" );
        }
    });
});

</script>
@endsection
