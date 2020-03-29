@extends('layouts.app')

@section('content')
    <div class="text-center bg-primary py-4 mb-5">
        <h1 class="text-white">Messagerie</h1>
    </div>

    <div class="container">
            @foreach ($topics as $topic)
            <div class="card card_message mb-2">
                <a href="{{ route('messagerie.show', ['topic' =>$topic, 'projet' => $topic->projet_id]) }}">
                    <div class="card_body row">
                        <div class="col-2 text-center align-self-center">
                            @if(Auth::user()->role === 'freelance')
                                @if ($topic->to->avatar === NULL)
                                    <img class="avatar_message" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/avatar.png">
                                @else
                                    <img class="avatar_message" src="{{ Storage::url('users/small/'. $topic->to->avatar) }}">
                                @endif
                            @elseif(Auth::user()->role === 'client')
                                @if (Auth::user()->avatar === NULL)
                                    <img class="avatar_message" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/avatar.png">
                                @else
                                    <img class="avatar_message" src="{{ Storage::url('users/small/'. Auth::user()->avatar ) }}">
                                @endif
                            @endif
                        </div>
                        <div class="col-10">
                            @if(Auth::user()->role === 'freelance')
                                @if($topic->to->pseudo)
                                    <span class="message_from_index">{{ $topic->to->pseudo }} <span class="message_preview_index">({{ $topic->messages->count() }})</span></span>
                                @else
                                    <span class="message_from_index">{{ $topic->to->firstname }} <span class="message_preview_index">({{ $topic->messages->count() }})</span></span>
                                @endif

                            @elseif(Auth::user()->role === 'client')
                                @if($topic->from->pseudo)
                                    <span class="message_from_index">{{ $topic->from->pseudo }} <span class="message_preview_index">({{ $topic->messages->count() }})</span></span>
                                @else
                                    <span class="message_from_index">{{ $topic->from->firstname }} <span class="message_preview_index">({{ $topic->messages->count() }})</span></span>
                                @endif

                            @endif
                            <p class="message_title_index"> {{ $topic->title }}</p>
                                @foreach ($topic->messages as $message)
                                    @if($loop->last)
                                        <p class="message_preview_index">"{{ Str::words($message->content, 20, '...') }}"</p>
                                    @endif
                                @endforeach
                        </div>
                    </div>
                </a>
            </div>

            @endforeach


    </div>

@endsection
