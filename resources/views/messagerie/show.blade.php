@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="mt-4">
            <div class="card" >
                <div class="card-header">
                    @if(auth::user()->role === 'client' && auth::user()->id === $topic->to_id)
                        Conversation avec {{$topic->from->firstname}}
                    @elseif(auth::user()->role === 'freelance')
                        Conversation avec Coco
                    @endif

                </div>

                <div class="card-body scroll" id="messagesBox">
                    @if (isset($messages))
                        @foreach ($messages as $message)
                            <div class="row">
                                <div class="col-md-10 {{ $message->from->id === $user->id ? 'offset-md-2 text-right' : ''}}">
                                    {{-- ------------- Si le contenu du message est vide (fichier à télécharger seulement) ---------------- --}}
                                    @if ($message->content === null)
                                        @isset($message->file_message)
                                            @if($message->from->pseudo)
                                                <p class="mb-0"><strong>{{ $message->from->id === $user->id ? 'Moi' : $message->from->pseudo}}</strong> <br></p>
                                            @else
                                                <p class="mb-0"><strong>{{ $message->from->id === $user->id ? 'Moi' : $message->from->firstname}}</strong> <br></p>
                                            @endif

                                            <p class="{{ $message->from->id === $user->id ? 'my_message' : 'his_message'}}">
                                                <a href="{{ route('messagerie.download', $message)}}"><i class="fas fa-download"></i> {{ $message->file_message }}</a>
                                            </p>
                                        @endisset
                                    {{-- ------------- Si le contenu du message n'est pas vide ---------------- --}}
                                    @else
                                        @if($message->from->pseudo)
                                            <p class="mb-0"><strong>{{ $message->from->id === $user->id ? 'Moi' : $message->from->pseudo}}</strong> <br></p>
                                        @else
                                            <p class="mb-0"><strong>{{ $message->from->id === $user->id ? 'Moi' : $message->from->firstname}}</strong> <br></p>
                                        @endif

                                        <p class="{{ $message->from->id === $user->id ? 'my_message' : 'his_message'}}">{!! nl2br(e($message->content)) !!}</p>
                                        @isset($message->file_message)
                                            @if ($message->content === null)
                                            @else
                                                <p class="{{ $message->from->id === $user->id ? 'my_message' : 'his_message'}}">
                                                    <a href="{{ route('messagerie.download', $message)}}"><i class="fas fa-download"></i> {{ $message->file_message }}</a>
                                                </p>
                                            @endif
                                    @endisset
                                    @endif
                                    {{-- ------------- Si le message contient une pièce jointe ---------------- --}}

                                </div>
                            </div>
                            <div class="message_date {{ $message->from->id === $user->id ? 'offset-md-2 text-right' : ''}}">{{ Carbon\Carbon::parse($message->created_at)->isoFormat('Do MMMM YYYY à h:mm') }}</div>
                        @endforeach
                    @else
                        <div class="text-center">
                            <em>Aucun message à afficher</em>
                        </div>


                    @endif
                </div>
            </div>
                <div class="mt-3">
                    <form action="{{ route('messagerie.store', $projet->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(auth::user()->role === 'client')
                            <input type="hidden" value="{{ $topic->from->id }}" name="to_id">
                        @else
                            <input type="hidden" value="{{ $projet->user->id }}" name="to_id">
                        @endif

                        <input type="hidden" value="{{ $topic->id ?? 0 }}" name="topic_id">
                        <div class="form-group">
                            <textarea class="form-control @error('content') is-invalid @enderror" placeholder="Votre message privé..." name="content" rows="3"></textarea>
                            @error('content')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- ---------------- Upload ------------------ -->
                        <div class="form-group">
                            <input type="file" class="form-control-file @error('file_projet') is-invalid @enderror" id="file-message" value="{{ old('file-message') }}" name="file_message">
                            @error('file_message')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    var messageBody = document.querySelector('#messageBody');
    messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;
</script>

@endsection
