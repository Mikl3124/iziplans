@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier mon profil</h1>
    <form action="{{ route('profil-update', Auth::user()) }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="card ">
            <div class="card-body row">
                <div class="col-md-2 text-center">
                        @if (Auth::user()->avatar === NULL)
                            <img id="blah_" class="mb-2 profil-avatar" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/avatar.png">
                        @else
                            <img id="blah_" class="mb-2 profil-avatar" src={{ $avatar }}>
                        @endif
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#exampleModal">
                            Modifier
                        </button>
                </div>
                <div class="col-md-10">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Email address</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Example select</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect2">Example multiple select</label>
                        <select multiple class="form-control" id="exampleFormControlSelect2">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Example textarea</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                        <button type="submit" class="btn btn-success mt-3">Sauvegarder</button>
                </div>
            </div>
        </div>            
    </form>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    @if (Auth::user()->avatar === NULL)
                        <img id="blah" class="mb-3 avatar-modal" src="https://iziplans.s3.eu-west-3.amazonaws.com/images/avatar.png">
                    @else
                        <img id="blah" class="mb-3 avatar-modal" src={{ $avatar }}>
                    @endif
                    <!-- Button trigger modal -->
                </div>
                <div class="text-center mb-3">
                    <button type="button" id="upload_link" class="btn btn-sm btn-outline-primary">Modifier la photo</button>
                </div>
                <form action="{{ route('image.upload', Auth::user()) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="file" id= "upload" name="avatar" onchange="readURL(this);" />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">Sauvegarder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
<script>
    $(function(){
    $("#upload_link").on('click', function(e){
        e.preventDefault();
        $("#upload:hidden").trigger('click');
    });
});
</script>



@endsection