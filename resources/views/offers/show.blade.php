@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $offer->projet->title }}</h1>
    <h5>{{ $offer->user->firstname }}</h5>
</div>
@endsection
