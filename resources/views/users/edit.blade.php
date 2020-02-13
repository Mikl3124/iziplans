@extends('layouts.app')

@section('content')
    <div class="container">
    <h1>Modifier mon profil</h1>
    <form action="{{ route('profil-update', Auth::user()) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card">
            <div class="card-body">
                @if (Auth::user()->avatar === NULL)
                    <img id="blah" class="mr-3 rounded profil-avatar" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/avatar.png">
                @else
                    <img id="blah" class="mr-3 rounded profil-avatar" src={{ $avatar }}>
                @endif
                <input type='file' id= "upload" name="avatar" onchange="readURL(this);" />
            </div>
            
        </div>

            <button type="submit" class="btn btn-success mt-3">Enregistrer la modification</button>

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