@extends('layouts.app')


@section('content')
    <div class="container">
        @foreach ($projet->offers as $offer)
            <a href="/offer-by-user/{{ $offer->user->id }}">{{ $offer->user->firstname }} {{ $offer->user->lastname }}</a>
        @endforeach
    </div>
@endsection