@extends('layouts.app')

@section('content')
<div class="container-fluid bg-primary">
    <div class="container py-4">
        @if($user->pseudo)
            <h1 class="text-left pt-5 text-white">{{ ucfirst($user->pseudo) }}</h1>
        @else
            <h1 class="text-left pt-5 text-white">{{ ucfirst($user->firstname) }} {{ ucfirst($user->lastname) }}</h1>
        @endif
        <div class="d-flex justify-content-start mb-5 ">
        <p>{{ ucfirst($user->titre) }}</p>
        </div>
    </div>
</div>
    <div class="container">
        <div class="row d-flex justify-content-between">
            <div class="col-md-4 my-2 col-sm-12 mt-n5">
                <div class="card card-show">
                    <div class="card card-show mb-3">
                      <div class="item">
                          @if ($user->updated_profil === 1)
                              <span class="notify-badge-show"><img class="verified-user" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/verified.png" alt="utilsateur vérifié"></span>
                          @endif
                            <img class="profil-avatar img-fluid w-100" src={{ $user->avatar }} alt="freelance avatar">
                      </div>

                    </div>
                </div>
            </div>
            <div class="card card-show mb-5 col-md-7 col-sm-12 mt-n5">
                <div class="row">
                    <div class="col-md-6 col-sm-12 text-center">
                        <p><em>Membre depuis le {{Carbon\Carbon::parse($user->created_at)->isoFormat('LL')}}</em></p>
                    </div>
                    <div class="col-md-6 col-sm-12 text-center">
                        @if ( !empty(Auth::user()) && Auth::user()->id === $user->id)
                            <a href="{{ route('profil-edit', Auth::user()) }}" class="btn btn-success">Modifier mon profil</a>
                        @endif
                    </div>
                </div>

                    <h3>PRÉSENTATATION</h3>
                    @if($user->presentation)
                      <p>{!! nl2br(e($user->presentation)) !!}</p>
                    @else
                      <p>Aucune présentation renseignée</p>
                    @endif
                    <h3>COMPÉTENCES</h3>
                    @if($user->categories && $user->categories->count() > 0)
                      @foreach($user->categories as $categorie)
                      <p>{{ $categorie->name }}</p>
                      @endforeach
                    @else
                      <p>Aucune catégorie sélectionnée</p>
                    @endif
                    <h3>LOCALISATION</h3>
                    <div id='map' style='width: 100%; height: 400px;'></div>

            </div >


<!-- ------------- Script Localisation ---------------------- -->

<script>
  var mapboxAccessKey = '{{ env('MAPBOX_ACCESS_TOKEN') }}';
    mapboxgl.accessToken = mapboxAccessKey ;
    var mapboxClient = mapboxSdk({ accessToken: mapboxgl.accessToken });
    mapboxClient.geocoding.forwardGeocode({
        query: "{{$user->address}} {{$user->town}} {{$user->cp}}",
        autocomplete: false,
        limit: 1
    })
        .send()
        .then(function (response) {
            if (response && response.body && response.body.features && response.body.features.length) {
                var feature = response.body.features[0];
                var map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: feature.center,
                    zoom: 5
                });
                new mapboxgl.Marker()
                    .setLngLat(feature.center)
                    .addTo(map);
            }
        });
</script>



@endsection
