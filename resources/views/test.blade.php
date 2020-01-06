@extends('layouts.app')

@section('content')
    <h1 class=text-center>test</h1>
    
    @auth
        @if (auth()->user()->subscribed('abonnement'))
        @else
            <h2>Abonnement Non Actif</h2>
        @endif
    @endauth
    @auth
        @if (auth()->user()->subscription('abonnement')->cancelled()) 
            <h2>Canceled</h2>
        @else
            <h2>No Canceled</h2>
        @endif
    @endauth

    

</div>
@endsection
