@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-3">Modifier mon profil</h1>
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
                  <form action="{{ route('profil-update', Auth::user()) }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <!-- ---------------- Prénom ------------------ -->
                        <div class="form-group col-md-6 col-sm-12 ">
                            <label for="firstname">Prénom</label>
                            <input type="text" class="form-control" name="firstname" value="{{old('firstname', $user->firstname)}}">
                        </div>
                        <!-- ---------------- Nom------------------ -->
                        <div class="form-group col-md-6 col-sm-12">
                            <label for="lastname">Nom</label>
                            <input type="text" class="form-control" name="lastname" value="{{old('lastname', $user->lastname)}}">
                        </div>
                    </div>

                     <!-- ---------------- Departements ------------------ -->
                     <div class="form-group ">
                        <label for="departements">Sélectionnez le(s) departement(s)</label>
                            <select class="form-control js-select" class="form-control"  name="departements[]" multiple="multiple">
                                @foreach($departements as $departement)
                                <option value="{{ $departement->id }}" @foreach ($user_departements as $user_departement)@if (old('departements', $departement->id ) == $user_departement->id) {{ 'selected' }} @endif @endforeach>{{ $departement->name }}</option>
                                @endforeach
                            </select>
                            @error('departements')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    <!-- ---------------- Case à cocher Alert Email Departements------------------ -->
                    <div class="form-check mt-n3 mb-2">
                        <input type="hidden" value="0" name="alert_departements">
                        <input type="checkbox" class="form-check-input" value="1" name="alert_departements" @if(old('alert_departements',$user->alert_departements)=="1") checked @endif >
                        <label class="form-check-label" for="alert-departements"><em>Me prévenir par e-mail, lorsque une mission correspond à mes lieux</em></label>
                    </div>
                    <!-- ---------------- Compétences ------------------ -->
                    <div class="form-group ">
                    <label for="competences">Sélectionnez vos compétences</label>
                        <select class="form-control js-select" name="competences[]" multiple="multiple">
                            @foreach($competences as $competence)
                                <option value="{{ $competence->id }}" @foreach ($user_competences as $user_competence)@if (old('competences', $competence->id ) == $user_competence->id) {{ 'selected' }} @endif @endforeach>{{ $competence->name }}</option>
                            @endforeach
                        </select>
                        @error('competences')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- ---------------- Case à cocher Alert Email Competences------------------ -->
                    <div class="form-check mt-n3 mb-2">
                        <input type="hidden" value="0" name="alert_competences">
                        <input type="checkbox" class="form-check-input" value="1" name="alert_competences" @if(old('alert_competences',$user->alert_competences)=="1") checked @endif >
                        <label class="form-check-label" for="alert-competences"><em>Me prévenir par e-mail, lorsque une mission correspond à mes compétences</em></label>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Sauvegarder</button>
                  </form>
                </div>
            </div>
        </div>
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
<script>
    $(document).ready(function() {
        $('.js-select').select2();
    });
</script>




@endsection
