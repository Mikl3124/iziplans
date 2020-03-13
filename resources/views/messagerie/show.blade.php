@extends('layouts.app')


@section('content')

    <div class="container">
        <div class="mt-4">
            <div class="card" >
                <div class="card-header">
                    Conversation avec {{$projet->user->firstname}}
                </div>
                <div class="card-body scroll" id="messagesBox">
                    @foreach ($messages as $message)
                        <div class="row">
                            <div class="col-md-10 {{ $message->from->id === $user->id ? 'offset-md-2 text-right' : ''}}">
                                <p><strong>{{ $message->from->id === $user->id ? 'Moi' : $message->from->firstname}}</strong> <br></p>
                                <p class="{{ $message->from->id === $user->id ? 'my_message' : 'his_message'}}">{!! nl2br(e($message->content)) !!}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
                <div class="mt-3">
                    <form action=""{{ route('messagerie.show', $projet->id)}}"" method="post">
                        @csrf
                        <input type="hidden" value="{{ $projet->user->id }}"name="to_id">
                        <div class="form-group">
                            <textarea class="form-control @error('content') is-invalid @enderror" placeholder="Votre message privé..." name="content" rows="3"></textarea>
                            @error('content')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    var messageBody = document.querySelector('#messagesBox');
    messagesBox.scrollTop = messagesBox.scrollHeight - messagesBox.clientHeight;
</script>

@endsection
