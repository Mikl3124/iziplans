@extends('layouts.app_without_navbar')
@section('content')
<div class="container">
    <div class="text-center my-5">
        <h2 >Bienvenue sur <a href="{{ route('home') }}"><img src="https://iziplans.s3.eu-west-3.amazonaws.com/images/iziplans-logo.png" id="logo-iziplans" alt="logo-iziplans"></a></h2>
    </div>
    <div class="card-block">
        <div class="text-center">
            <p>Choisissez votre type de compte :</p>
            <div class="row">
                <div class="col-md-6 mt-3 text-center">
                    <div class="mb-3" >
                        <a href="{{ route('register_client') }}"><i class="icon-register fas fa-user"></i></a>
                    </div>
                    <p class="mb-0">CLIENT</p>
                    <p>(j'ai un projet à faire réaliser)</p>
                </div>
                <div class="col-md-6 mt-3 text-center">
                    <div>
                        <div class="mb-3">
                            <a href="{{ route('register_freelance') }}"><i class="icon-register fas fa-pencil-ruler"></i></a>
                        </div>
                        <p class="mb-0">FREELANCE</p>
                        <p>(je cherche des missions)</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mt-5">
            <p>Déjà inscrit sur iziplans ? <a href="{{ route('login') }}"> Connectez-vous</a></p>
        </div>
    </div>
</div>

@endsection
