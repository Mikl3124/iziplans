@extends('layouts.app')

@section('content')
    <div class="container">

        <h1 class=text-center>Liste des messages</h1>
          <ul>
            @foreach ($topics as $topic)
            <p>{{ $topic->from->firstname }} <a href="{{ route('messagerie.show', ['topic' =>$topic, 'projet' => $topic->projet_id]) }}">{{ $topic->title }}</a></p>
                @foreach ($topic->messages as $message)
                    @if($loop->last)
                        {{ $message->content }}
                    @endif
                @endforeach
            @endforeach
          </ul>

    </div>

@endsection
