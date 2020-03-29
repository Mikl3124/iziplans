@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $offer->projet->title }}</h1>
    @if($offer->user->pseudo)
        <h5>{{ $offer->user->pseudo }}</h5>
    @else
        <h5>{{ $offer->user->firstname }}</h5>
    @endif

</div>
@endsection
