@extends('layouts.app')

@section('content')
<div class="container-fluid bg-primary">
    <div class="container py-4">
        <h1 class="text-left pt-5 text-white">Comment ça marche ?</h1>
    </div>
</div>
    <div class="container">
        <h3 class="text-center my-3">Vous avez besoin d’un professionnel ?</h3>        <p class="p1"><span class="s1">Que vous soyez un particulier ou une entreprise vous pouvez trouver facilement et gratuitement un prestataire sur la plateforme.</span></p>
        <p class="p1"><span class="s1"><u>Pour cela, il suffit de :</u></span></p>
        <p class="p1"><span class="s1">1-Vous inscrire en tant que “porteur de projet” -> <a href="{{ route('register_choice') }}"><span class="s2"><b>Page Inscription</b></span></a></span></p>
        <p class="p1"><span class="s1">2-Créer et publier votre annonce” -> <a href="{{route('projet.create')}}"><span class="s2"><b>Page déposer un projet</b></span></a></span></p>
        <p class="p1"><span class="s1"></span></p>

    </div>

@endsection
