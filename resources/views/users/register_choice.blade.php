@extends('layouts.app')
@section('content')
    <div class="container">
        <h3 class="text-center my-5">Choisissez votre type de compte</h3>
        <div class="row">
            <div class="col-md-6 text-center">
                <div class="mb-3" >
                    <a href="{{ route('register', 'client') }}"><i class="icon-register fas fa-user"></i></a>
                </div>
                <p class="mb-0">CLIENT</p>
                <p>(j'ai un projet à faire réaliser)</p>
            </div>
            <div class="col-md-6 text-center">
                <div>
                    <div class="mb-3">
                        <a href="{{ route('register', 'freelance') }}"><i class="icon-register fas fa-pencil-ruler"></i></a>
                    </div>
                    <p class="mb-0">FREELANCE</p>
                    <p>(je cherche des missions)</p>
                </div>
            </div>
        </div>
    </div>
    
@endsection