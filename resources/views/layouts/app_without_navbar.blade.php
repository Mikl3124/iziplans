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

    <!-- Favicon -->

    <link rel="apple-touch-icon" sizes="180x180" href="https://iziplans.s3.eu-west-3.amazonaws.com/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://iziplans.s3.eu-west-3.amazonaws.com/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://iziplans.s3.eu-west-3.amazonaws.com/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="https://iziplans.s3.eu-west-3.amazonaws.com/images/favicons/site.webmanifest">



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-146702848-2');
    </script>

    <!-- empecher l'indexation des moteurs de recherche -->
    <meta name="robots" content="noindex">

</head>
<body>
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
