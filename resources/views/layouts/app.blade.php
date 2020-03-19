<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'iziplans') }}</title>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="{{ asset('js/app.js') }}" ></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">


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

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if (Auth::user()->avatar === NULL)
                                    <img class="mr-3 rounded-circle navbar-avatar" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/avatar.png"><span class="caret">{{ Auth::user()->firstname }}</span>
                                    @else
                                        <img class="mr-3 rounded-circle navbar-avatar" src="{{ Storage::url('users/small/'. Auth::user()->avatar) }}"><span class="caret">{{ Auth::user()->firstname }}</span>
                                    @endif
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->role === 'client')
                                        <div class="text-center">
                                            <a class="btn btn-success btn-lg btn-menu" href="{{route('projets.create')}}"><i class="far fa-plus-square text-white"></i> Déposer un projet</a>
                                        </div>
                                        <h6 class=text-center>MON COMPTE</h6>
                                        <a class="dropdown-item" href="{{ route('messagerie.index', Auth::user()) }}"><i class="far fa-envelope"></i> Messagerie</a>
                                        <a class="dropdown-item" href="{{ route('profil', Auth::user()) }}"><i class="fas fa-phone-alt"></i> Mes coordonnées</a>
                                    <hr>
                                        <h6 class=text-center>PROJETS</h6>
                                        <a class="dropdown-item" href="{{ route('profil', Auth::user()) }}"><i class="fas fa-suitcase"></i> Gérer mes projets</a>           
                                    @elseif(Auth::user()->role === 'freelance')
                                        <a class="dropdown-item" href="{{ route('messagerie.index', Auth::user()) }}">Messagerie</a>
                                        <a class="dropdown-item" href="{{ route('profil', Auth::user()) }}">Mon profil</a>
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
                    @auth
                        @if (Auth::user()->role=='admin')
                            <div>
                                <a href="/dashboard" type="submit" class="btn btn-secondary">Tableau de Bord</a>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
        @yield('js-exemple')
    </div>

</body>
</html>
