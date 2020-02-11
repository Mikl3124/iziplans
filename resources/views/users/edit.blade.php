@extends('layouts.app')

@section('content')
    <div class="container">
    <h1>Modifier mon profil</h1>
    <form action="{{ route('profil-update', Auth::user()) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card">
            <div class="card-body">
                <input type='file' name="avatar" onchange="readURL(this);" />
            <img id="blah" src="{{ Storage::disk('s3')->url(Auth::user()->avatar) }}" alt="avatar-{{Auth::user()->firstname}}" />
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success">Enregistrer la modification</button>
        </div>
    </form>
    
</div>

<script>
     function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>

@endsection