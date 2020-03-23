@extends('layouts.app_without_navbar')

@section('content')
<div class="container">
    <div class="text-center my-5">
        <h2 >Bienvenue sur <a href="{{route('home')}}"><img src="https://iziplans.s3.eu-west-3.amazonaws.com/images/iziplans-logo.png" id="logo-iziplans" alt="logo-iziplans"></a></h2>
    </div>
    <div class="card-block">
        <div class="text-center">
            <p class="mb-0">Connectez-vous rapidement :</p>
            <div class="row justify-content-center">
                {{-- ---------------- Social connection ---------------- --}}
                <div class="col-md-4 col-sm-12 my-1">
                    <a href="{{route('social-login.redirect', 'google')}}" class="signing-button google"><img class="img_google" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/google.svg" alt=""> Continuer avec Google</a>
                </div>
                <div class="col-md-4 col-sm-12 my-1">
                    <a href="{{route('social-login.redirect', 'facebook')}}" class="signing-button facebook"><i class="fab fa-facebook-f"></i> Continuer avec Facebook</a>
                </div>
                    <a href="{{route('social-login.redirect', 'github')}}">github</a>
            </div>
            <div class="row">
                <div class="col-12">
                    OU
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-2">
                    <div class="card-body">
                        <div class=text-center>
                            <p>Connectez-vous avec un mot de passe :</p>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                        @if(isset($projet))
                            <input type="hidden" name="projet" value="{{ $projet }}">
                        @endif
                            <div class="form-group">
                                <input placeholder="Adresse e-mail" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group" id="show_hide_password_1">
                                    <input placeholder="Mot de passe" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
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

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        Se souvenir de moi
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        Se connecter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                        <p>Pas encore membre ?  <a href="{{route('register_choice')}}">Cliquez-ici</a> pour vous inscrire</p>
                    <div>
                        @if (Route::has('password.request'))
                            <p class="text-center"><a href="{{ route('password.request') }}">J'ai perdu mon mot de passe </a></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
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
    });
</script>

@endsection
