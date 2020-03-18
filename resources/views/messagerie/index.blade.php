@extends('layouts.app')

@section('content')
    <div class="container">

        <h1 class=text-center>Liste des messages</h1>
            @foreach ($topics as $topic)
            <div class="message_index">
                <a href="{{ route('messagerie.show', ['topic' =>$topic, 'projet' => $topic->projet_id]) }}">
                    <div class="pt-2 d-flex flex-row">
                        <div class="message_index_avatar">
                            @if(Auth::user()->role === 'freelance')
                                @if ($topic->to->avatar === NULL)
                                    <img class="mr-3 rounded-circle navbar-avatar" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/avatar.png"> 
                                @else
                                    <img class="mr-3 rounded-circle navbar-avatar" src="{{ Storage::url('users/small/'. $topic->to->avatar) }}">
                                @endif
                            @elseif(Auth::user()->role === 'client')
                                @if (Auth::user()->avatar === NULL)
                                    <img class="mr-3 rounded-circle navbar-avatar" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/avatar.png"> 
                                @else
                                    <img class="mr-3 rounded-circle navbar-avatar" src="{{ Storage::url('users/small/'. Auth::user()->avatar ) }}">
                                @endif
                            @endif
                        </div>
                        <div>
                            @if(Auth::user()->role === 'freelance')
                                <span class="message_from_index">{{ $topic->to->firstname }} <span class="message_preview_index">({{ $topic->messages->count() }})</span></span>
                            @elseif(Auth::user()->role === 'client')
                                <span class="message_from_index">{{ $topic->from->firstname }} <span class="message_preview_index">({{ $topic->messages->count() }})</span></span>
                            @endif
                            <p class="message_title_index"> {{ $topic->title }}</p>
                                @foreach ($topic->messages as $message)
                                    @if($loop->last)
                                        <p class="message_preview_index">{{ substr($message->content, 0, 40) }} ...</p>
                                    @endif
                                @endforeach
                        </div>  
                    </div>
                </a>
                <hr class="mt-0 mb-0">
            </div>
            
            @endforeach
            

    </div>

@endsection
