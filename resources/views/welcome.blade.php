@extends('layouts.app')

@section('content')

   {{-- ----------- Banner ---------- --}}
<div class="banner" style="background-image:url(https://iziplans.s3.eu-west-3.amazonaws.com/images/iziplans-banner.jpg)">
    <div class="container">
        <div class="display-4 text-center text-white">VOS PLANS FACILEMENT</div>
        <blockquote class="blockquote text-center">
            {{-- ----------- L'utilisateur n'est pas enregistré ---------- --}}
            @guest
                <p class="mb-0">Trouvez le professionnel idéal pour votre projet</p>
            @endguest
            @auth
            {{-- ----------- L'utilisateur n'est pas enregistré ---------- --}}
                @if (Auth::user()->role === 'client')
                {{-- ----------- L'utilisateur est client ---------- --}}
                    <p class="mb-0">Trouvez le professionnel idéal pour votre projet</p>
                @elseif (Auth::user()->role === 'freelance')
                    <p class="mb-0">Trouvez la mission qui vous correspond</p>
                @endif

            @endauth
        </blockquote>
        @guest
        {{-- ----------- L'utilisateur n'est pas enregistré ---------- --}}
            <div class="row">
                <div class="col-md-6 col-sm-12 mt-5 text-center">
                    <a class="btn btn-primary btn-lg text-center" href="{{ route('register_freelance') }}">Devenir Freelance</a>
                </div>
                <div class="col-md-6 col-sm-12 mt-5 text-center">
                    <a class="btn btn-primary btn-lg " href="{{ route('register_client') }}">Déposer un projet</a>
                </div>
            </div>
        @endguest
        @auth
            <div class="row">
        {{-- ----------- L'utilisateur est enregistré ---------- --}}
            @if(Auth::user()->role === 'client')
            {{-- ----------- L'utilisateur est client ---------- --}}
                    <div class="col-md-6 col-sm-12 mt-5 text-center">
                        <a class="btn btn-primary btn-lg text-center" href="{{route('projet.list')}}"></i> Gérer mes projets</a>
                    </div>
                    <div class="col-md-6 col-sm-12 mt-5 text-center">
                        <a class="btn btn-success btn-lg " href="{{route('projet.create')}}"></i> Publier un projet</a>
                    </div>

            @elseif(Auth::user()->role === 'freelance')
            {{-- ----------- L'utilisateur est freelance ---------- --}}
                    <div class="col-md-6 col-sm-12 mt-5 text-center">
                        <a class="btn btn-primary btn-lg text-center" href="{{route('projet.list')}}"></i> Gérer mes missions</a>
                    </div>
                    <div class="col-md-6 col-sm-12 mt-5 text-center">
                        <a class="btn btn-success btn-lg " href="{{route('projet.index')}}"></i> Voir toutes les missions</a>
                    </div>
            @endif
            </div>
        @endauth
    </div>
</div>

{{-- ----------- Banner ---------- --}}
<div class="container">

    {{-- ----------- Dernières Missions Proposées ---------- --}}

    <div class="text-center">
        <h1 class="text-center mt-5 mb-5 last_missions">Les dernières missions</h1>
    </div>
    {{-- ----------- 3 Derniers Projets ---------- --}}
        @foreach ($projets_first as $projet)
        <a href="{{ route('projet.show', $projet) }}">
            <div class="card card-project-home mb-3">
                <div class="card-body">
                    <div class="d-flex">
                        <h2 class="list-project-title">{{ ucfirst($projet->title )}}</h2>
                        <span class="data-card-date ml-2">Posté il y a {{Carbon\Carbon::parse($projet->created_at)->diffForHumans()}}</span>
                    </div>
                    <div class="row d-flex ml-1 justify-content-start">
                        @if ($projet->status === "open")
                            <span class="data-card ml-1"><i class="fas fa-circle text-success"></i> Ouvert |</span>
                        @elseif ($projet->status === "closed")
                            <span class="data-card ml-1"><i class="fas fa-circle text-secondary"></i> Fermé |</span>
                        @endif
                        <span class="data-card  ml-1"><i class="fas fa-map-marker-alt"></i> {{$projet->departement->name}} |</span>
                        <span class="data-card ml-1"><i class="fas fa-euro-sign"></i> {{ $projet->budget->name }} |</span>
                        @if($projet->offers->count() == 0)
                            <span class="data-card ml-1"><i class="fas fa-gavel"></i> Aucune offre |</span>
                        @else
                            <span class="data-card ml-1"><i class="fas fa-gavel"></i> {{ $projet->offers->count()}} {{ $projet->offers->count() === 1 ? 'Offre' : 'Offres'}} |</span>
                        @endif
                            <span class="data-card ml-1"><i class="fas fa-eye"></i> {{ views($projet)->unique()->count() }} {{views($projet)->unique()->count() === 1 ? 'Vue' : 'Vues'}}</span>
                    </div>
                    <hr>
                    <p class="card-text">{{ ucfirst(Str::words($projet->description, 45, '...')) }}</p>

                    @foreach($projet->categories as $category)
                        <span class="categories">{{ $category->name }} </span>
                    @endforeach

                </div>
            </div>
        </a>
        @endforeach
    {{-- ----------- Call to action ---------- --}}
        <div class="card card-pub-home mb-3">
            <div class="card-body ">
               {{-- ----------- L'utilisateur n'est pas enregistré ---------- --}}
                @guest
                    <p class= "title-call-to-action">Besoins de plans ? Déposez une annonce gratuitement</p>
                    <p class= "text-call-to-action">Recevez vos premiers devis rapidement</p>
                    <a class="btn btn-success btn-lg" href="{{ route('register_client') }}">Recevoir des devis</a>
                @endguest
                {{-- ----------- L'utilisateur est pas enregistré ---------- --}}
                @auth
                    {{-- ----------- Si c'est un client ---------- --}}
                    @if (Auth::user()->role === 'client')
                        <p class= "title-call-to-action">Besoins de plans ? Déposez une annonce gratuitement</p>
                        <p class= "text-call-to-action">Recevez vos premiers devis rapidement</p>
                        <a class="btn btn-success btn-lg" href="{{ route('projet.create') }}">Recevoir des devis</a>
                    {{-- ----------- Si c'est un freelance ---------- --}}
                    @elseif (Auth::user()->role === 'freelance')
                        <p class= "title-call-to-action">Vous recherchez une mission ?</p>
                        <p class= "text-call-to-action">Consultez l'ensemble des offres disponibles</p>
                        <a class="btn btn-success btn-lg" href="{{ route('projet.index') }}">Voir les missions</a>
                    @endif

                @endauth
            </div>
        </div>

    {{-- ----------- 3 Projets Suivants ---------- --}}
        @foreach ($projets_seconds as $projet)
      <a href="{{ route('projet.show', $projet) }}">
            <div class="card card-project-home mb-3">
                <div class="card-body">
                    <div class="d-flex">
                        <h2 class="list-project-title">{{ ucfirst($projet->title )}}</h2>
                        <span class="data-card-date ml-2">Posté il y a {{Carbon\Carbon::parse($projet->created_at)->diffForHumans()}}</span>
                    </div>
                    <div class="row d-flex ml-1 justify-content-start">
                        @if ($projet->status === "open")
                            <span class="data-card ml-1"><i class="fas fa-circle text-success"></i> Ouvert |</span>
                        @elseif ($projet->status === "closed")
                            <span class="data-card ml-1"><i class="fas fa-circle text-secondary"></i> Fermé |</span>
                        @endif
                        <span class="data-card  ml-1"><i class="fas fa-map-marker-alt"></i> {{$projet->departement->name}} |</span>
                        <span class="data-card ml-1"><i class="fas fa-euro-sign"></i> {{ $projet->budget->name }} |</span>
                        @if($projet->offers->count() == 0)
                            <span class="data-card ml-1"><i class="fas fa-gavel"></i> Aucune offre |</span>
                        @else
                            <span class="data-card ml-1"><i class="fas fa-gavel"></i> {{ $projet->offers->count()}} {{ $projet->offers->count() === 1 ? 'Offre' : 'Offres'}} |</span>
                        @endif
                            <span class="data-card ml-1"><i class="fas fa-eye"></i> {{ views($projet)->unique()->count() }} {{views($projet)->unique()->count() === 1 ? 'Vue' : 'Vues'}}</span>
                    </div>
                    <hr>
                    <p class="card-text">{{ ucfirst(Str::words($projet->description, 45, '...')) }}</p>

                    @foreach($projet->categories as $category)
                        <span class="categories">{{ $category->name }} </span>
                    @endforeach
                </div>
            </div>
        </a>
        @endforeach
        <div class="text-center">
          <a class="btn btn-primary btn-lg mt-3" href="{{ route('projet.index') }}">Voir toutes les missions</a>
        </div>
    {{-- ----------- Comment ça marche ? ---------- --}}
<div class="text-center mt-5">
    <h1 class="text-center mb-5">Comment ça marche?</h1>
    <div class="row d-flex justify-content-around">
        <div class="col-lg-3 col-sm-6">
            <div >
                <img src="https://iziplans.s3.eu-west-3.amazonaws.com/images/paper-plane-1.png" class="card-img-iziplans" alt="demande de mission">
                <div class="card-body">
                    <p class="card-text">Postez votre demande de mission gratuitement, pour obtenir vos offres</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div >
                <img src="https://iziplans.s3.eu-west-3.amazonaws.com/images/discuss-issue-1.png" class="card-img-iziplans" alt="propositions de devis">
                <div class="card-body">
                    <p class="card-text">Recevez en moins de 24h, des propositions de prestataires qualifiés</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div >
                <img src="https://iziplans.s3.eu-west-3.amazonaws.com/images/choice-1.png" class="card-img-iziplans" alt="consultez les profils">
                <div class="card-body">
                    <p class="card-text">Consultez librement les profils des prestataires et les avis pour faire votre choix</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6">
            <div >
                <img src="https://iziplans.s3.eu-west-3.amazonaws.com/images/team-1.png" class="card-img-iziplans" alt="echangez discutez">
                <div class="card-body">
                    <p class="card-text">Echangez, discutez et négociez sans intermédiaire, avec les prestataires de votre choix</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
      $('.js-select').select2();
  });
  </script>

  <script>
      $(document).ready(function() {
  prep_modal();
});

function prep_modal()
{
  $(".modal").each(function() {

  var element = this;
	var pages = $(this).find('.modal-split');

  if (pages.length != 0)
  {
    	pages.hide();
    	pages.eq(0).show();

    	var b_button = document.createElement("button");
                b_button.setAttribute("type","button");
          			b_button.setAttribute("class","btn btn-primary");
          			b_button.setAttribute("style","display: none;");
          			b_button.innerHTML = "Back";

    	var n_button = document.createElement("button");
                n_button.setAttribute("type","button");
          			n_button.setAttribute("class","btn btn-primary");
          			n_button.innerHTML = "Next";

    	$(this).find('.modal-footer').append(b_button).append(n_button);


    	var page_track = 0;

    	$(n_button).click(function() {

        this.blur();

    		if(page_track == 0)
    		{
    			$(b_button).show();
    		}

    		if(page_track == pages.length-2)
    		{
    			$(n_button).text("Submit");
    		}

        if(page_track == pages.length-1)
        {
          $(element).find("form").submit();
        }

    		if(page_track < pages.length-1)
    		{
    			page_track++;

    			pages.hide();
    			pages.eq(page_track).show();
    		}


    	});

    	$(b_button).click(function() {

    		if(page_track == 1)
    		{
    			$(b_button).hide();
    		}

    		if(page_track == pages.length-1)
    		{
    			$(n_button).text("Next");
    		}

    		if(page_track > 0)
    		{
    			page_track--;

    			pages.hide();
    			pages.eq(page_track).show();
    		}


    	});

  }

  });
}
  </script>
@endsection

