<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'iziplans') }}</title>

    <!-- Meta Descriptions-->
    <meta name="description" content="Trouvez le professionnel idéal pour votre projet">
    <meta name="image" content="https://iziplans.s3.eu-west-3.amazonaws.com/images/iziplans-logo.png">
    <!-- Schema.org for Google -->
    <meta itemprop="name" content="Vos plans facilement">
    <meta itemprop="description" content="Trouvez le professionnel idéal pour votre projet">
    <meta itemprop="image" content="https://iziplans.s3.eu-west-3.amazonaws.com/images/iziplans-logo.png">
    <!-- Open Graph general (Facebook, Pinterest & Google+) -->
    <meta name="og:title" content="Vos plans facilement">
    <meta name="og:description" content="Trouvez le professionnel idéal pour votre projet">
    <meta name="og:image" content="https://iziplans.s3.eu-west-3.amazonaws.com/images/iziplans-logo.png">
    <meta name="og:url" content="https://iziplans.com">
    <meta name="og:site_name" content="iziplans">
    <meta name="og:locale" content="fr_FR">
    <meta name="og:type" content="website">

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="{{ asset('js/app.js') }}" ></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <!-- Mapbox  -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v1.8.1/mapbox-gl.css' rel='stylesheet' />


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">

    <!-- Favicon -->

    <link rel="apple-touch-icon" sizes="180x180" href="https://iziplans.s3.eu-west-3.amazonaws.com/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://iziplans.s3.eu-west-3.amazonaws.com/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://iziplans.s3.eu-west-3.amazonaws.com/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="https://iziplans.s3.eu-west-3.amazonaws.com/images/favicons/site.webmanifest">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="https://iziplans.s3.eu-west-3.amazonaws.com/images/iziplans-logo.png" id="logo-iziplans" alt="logo-iziplans">
            </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
        {{-- ---------- Notification Profil à compléter -------------- --}}
                @auth
                    @if(Auth::user()->role === "freelance" && Auth::user()->updated_profil === 0)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    N'oubliez pas de <a href="{{ route('profil-edit', Auth::user()) }}" class="updateProfilAlertLink"><u>compléter votre profil</u></a> pour être averti des nouvelles missions par email !
                      </div>
                    @endif

                @endauth
        {{-- ---------- Si il y a des notifications -------------- --}}
                @auth
                    @unless (auth()->user()->unreadNotifications->isEmpty())
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle notif_messages" type="button" data-toggle="dropdown">
                            @if (auth()->user()->unreadNotifications->count() === 1)
                                <i class="far fa-bell text-white"></i> 1 message reçu
                            @elseif (auth()->user()->unreadNotifications->count() > 1)
                                <i class="far fa-bell text-white"></i> {{ auth()->user()->unreadNotifications->count()}} messages reçus
                            @endif
                        </button>
                {{-- ---------- On liste les messages -------------- --}}
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach (auth()->user()->unreadNotifications as $notification)
                                <a class="dropdown-item" href="{{ route('topics.showFromNotifications', ['topic' => $notification['data']['topicId'], 'notification' => $notification->id])}}">{{ $notification->data['firstname'] }} a posté un message</a>
                            @endforeach
                        </div>
                      </div>
                    @endunless
                @endauth
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register_choice') }}">Inscription</a>
                                </li>
                            @endif
                            <li>
                                <a class="btn btn-success"href="{{ route('register_client') }}">Besoin de plans ?</a>
                            </li>
                        @else

                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img class="mr-3 rounded-circle navbar-avatar" src="{{ Auth::user()->avatar }}">
                                    @if(Auth::user()->pseudo)
                                        <span class="caret">{{ Auth::user()->pseudo }}</span>
                                    @else
                                        <span class="caret">{{ Auth::user()->firstname }}</span>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    {{-- ------------------------ Si l'utilisateur est un client ----------------------- --}}
                                    @if(Auth::user()->role === 'client')
                                    <div class="text-center">
                                        <p class="mb-0">Vous êtes Client</p>
                                        <a href="{{ route('changeRole') }}"><small>(Basculer vers l'interface FREELANCE)</small></a>
                                    </div>
                                        <div class="text-center">
                                            <a class="btn btn-success btn-lg btn-menu mt-3" href="{{route('projet.create')}}">Déposer un projet</a>
                                        </div>
                                        <h6 class="text-center bg-secondary text-white p-2">MON COMPTE</h6>
                                        <a class="dropdown-item" href="{{ route('messagerie.index', Auth::user()) }}"><i class="far fa-envelope"></i> Messagerie
                                        {{-- ------- Compteur de notifications de messages -------- --}}
                                            @unless (auth()->user()->unreadNotifications->isEmpty())
                                                <span class="text-primary"> ({{ auth()->user()->unreadNotifications->count()}})</span>
                                            @endunless
                                        </a>
                                        <a class="dropdown-item" href="{{ route('profil', Auth::user()) }}"><i class="fas fa-user"></i> Mon compte</a>
                                        <h6 class="text-center bg-secondary text-white p-2">PROJETS</h6>
                                        <a class="dropdown-item" href="{{ route('projet.index') }}"><i class="fas fa-suitcase"></i> Gérer mes projets</a>
                                    {{-- ------------------------ Si l'utilisateur est un freelance ----------------------- --}}
                                    @elseif(Auth::user()->role === 'freelance')
                                        <div class="text-center">
                                            <p class="mb-0">Vous êtes Freelance</p>
                                        <a href="{{ route('changeRole') }}"><small>(Basculer vers l'interface CLIENT)</small></a>
                                        </div>
                                        <div class="text-center">
                                            <a class="btn btn-success btn-lg btn-menu mt-3" href="{{route('projet.index')}}">Voir les missions</a>
                                        </div>
                                            <h6 class="text-center bg-secondary text-white p-2">MON COMPTE</h6>
                                        <a class="dropdown-item" href="{{ route('messagerie.index', Auth::user()) }}"><i class="far fa-envelope"></i> Messagerie
                                            @unless (auth()->user()->unreadNotifications->isEmpty())
                                                ({{ auth()->user()->unreadNotifications->count()}})
                                            @endunless
                                        </a>

                                        </a>
                                        <a class="dropdown-item" href="{{ route('profil', Auth::user()) }}"><i class="fas fa-user"></i> Mon compte</a>
                                        <a class="dropdown-item" href="{{ route('subscription', Auth::user()) }}"><i class="fas fa-shopping-cart"></i></i> Mon abonnement</a>
                                {{-- ------------------------ Si l'utilisateur est un admin ----------------------- --}}
                                    @elseif(Auth::user()->role === 'admin')
                                        <div class="text-center">
                                            <p class="mb-0">Vous êtes Admin</p>
                                        </div>
                                        <hr>
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                        <a class="dropdown-item" href="{{ route('admin.users.list') }}">Utilisateurs</a>
                                        <a class="dropdown-item" href="{{ route('admin.projets.list') }}">Projets</a>
                                    @endif
                                    <hr>
                                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt text-danger"></i> Se déconnecter
                                        </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
@include('flashy::message')

 <!--Footer-->

    <footer class="page-footer text-center text-md-left bg-dark mt-5">
        <div class="container">
            <div>
                <!--Call to action-->
                <div class="row justify-content-between">
                        <div class="col-md-4 mt-2" >
                            <a href="{{ url('/') }}">
                                <img class="footer-brand" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/Favicon-iziplans.png" alt="logo-iziplans">
                            </a>
                        </div>
                        <div class="col-md-4 mt-2 my-auto text-right bg-dark">
                        <small class=""><a href="{{ route('cgv')}}" class="link-footer text-white">CGV</a></small>
                            <small class="text-white"> | </small>
                        <small><a href="{{ route('politique')}}" class="link-footer text-white">Politique de confidentialité</a></small>
                        </div>
                </div>
            </div>
        </div>


        <!--/.Call to action-->
    </footer>
    <!--/.Footer-->
    {{-- Tidio --}}
    <script src="//code.tidio.co/2mpdnkepz7xduaizuowdgkxas7xk44br.js" async></script>
</body>
