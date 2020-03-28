@extends('layouts.app')

@section('content')
<div class="container-fluid bg-primary">
    <div class="container py-4">
        <h1 class="text-left pt-5 text-white">{{ ucfirst($user->firstname) }} {{ ucfirst($user->lastname) }}</h1>
        <div class="d-flex justify-content-start mb-5 ">
        <p>{{ ucfirst($user->titre) }}</p>
        </div>
    </div>
</div>
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-md-4 my-2 col-sm-12 mt-n5">
                <div class="card card-show">
                    <div class="card card-show bg-dark mb-3">
                        <img class="rounded profil-avatar my-auto mx-auto" src={{ $avatar }}>
                    </div>
                </div>
            </div>
            <div class="card card-show mb-5 col-md-7 col-sm-12 mt-n5">
                <p><em>Membre depuis le {{Carbon\Carbon::parse($user->created_at)->isoFormat('LL')}}</em></p>
                <div class="mb-4">

                </div>
                <div>
                    <p>COCO</p>
                </div>
            </div >


@endsection
