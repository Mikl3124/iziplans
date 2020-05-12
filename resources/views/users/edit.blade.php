@extends('layouts.app')

<script src="https://cdn.jsdelivr.net/npm/places.js@1.18.1"></script>

@section('content')
    <div class="container">
        <div class="card mt-3">
            <div class="card-body">
                <div class="text-center">
                    <h3 class="mb-3">MODIFICATION DU PROFIL</h3>
                    @error('avatar')
                    <div class="alert alert-danger alert-dismissible fade show text-center mb-2" role="alert">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-2 text-center">
                        <img id="blah_" class="mb-2 profil-avatar" src={{ Auth::user()->avatar }}>
                        <!-- Bouton modal -->
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
                                    <label for="firstname">Prénom<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control" name="firstname" value="{{old('firstname', $user->firstname)}}">
                                </div>
                                <!-- ---------------- Nom------------------ -->
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="lastname">Nom<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control" name="lastname" value="{{old('lastname', $user->lastname)}}">
                                </div>
                            </div>

                    <!-- ---------------- Si l'utilsateur est Freelance ------------------ -->
                            @if(Auth::user()->role === 'freelance')
                                <div class="form-row">
                                <!-- ---------------- Pseudo ------------------ -->
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="titre">Nom d'affichage (Pseudo)</label>
                                        <input type="text" class="form-control" name="pseudo" value="{{old('pseudo', $user->pseudo)}}">
                                    </div>
                                <!-- ---------------- Titre professionnel ------------------ -->
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="titre">Titre professionnel</label>
                                        <input type="text" class="form-control" name="titre" value="{{old('titre', $user->titre)}}">
                                    </div>
                                </div>
                                <!-- ---------------- Departements ------------------ -->
                                <div class="form-group ">
                                    <label for="departements">Vos lieux</label>
                                        <select class="form-control js-select" class="form-control"  name="departements[]" multiple="multiple">
                                            @foreach($departements as $departement)
                                            <option value="{{ $departement->id }}" @foreach ($user_departements as $user_departement)@if (old('departements', $departement->id ) == $user_departement->id) {{ 'selected' }} @endif @endforeach>{{ $departement->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('departements')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                </div>
                                <!-- ---------------- Checkbox Alert Email Departements------------------ -->
                                <div class="form-check mt-n3 mb-2">
                                    <input type="hidden" value="0" name="alert_departements">
                                    <input type="checkbox" class="form-check-input" value="1" name="alert_departements" @if(old('alert_departements',$user->alert_departements)=="1") checked @endif >
                                    <label class="form-check-label" for="alert-departements"><em>Me prévenir par e-mail, lorsque une mission correspond à mes lieux</em></label>
                                </div>
                                <!-- ---------------- Compétences ------------------ -->
                                <div class="form-group ">
                                <label for="categories">Vos domaines de compétences</label>
                                    <select class="form-control js-select" name="categories[]" multiple="multiple">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" @foreach ($user_categories as $user_category)@if (old('categories', $category->id ) == $user_category->id) {{ 'selected' }} @endif @endforeach>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('categories')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- ---------------- Checkbox Alert Email categories------------------ -->
                                <div class="form-check mt-n3 mb-2">
                                    <input type="hidden" value="0" name="alert_categories">
                                    <input type="checkbox" class="form-check-input" value="1" name="alert_categories" @if(old('alert_categories',$user->alert_categories)=="1") checked @endif >
                                    <label class="form-check-label" for="alert-categories"><em>Me prévenir par e-mail, lorsque une mission correspond à mes compétences</em></label>
                                </div>
                                <!-- ---------------- Présentation ------------------ -->
                                <div class="form-group">
                                    <label for="presentation">Votre présentation</label>
                                    <textarea class="form-control" id="presentation" name="presentation" rows="8">{{old('presentation', $user->presentation)}}</textarea>
                                </div>
                            @endif
                    <!-- ---------------- Si l'utilsateur est Client ------------------ -->
                            <div class="form-group">
                                <label for="form-address">Adresse</label>
                                <input type="search" value="{{old('address', $user->address)}}" class="form-control @error('address') is-invalid @enderror" id="form-address"
                                name="address" placeholder="Veuillez saisir votre adresse" />
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-4">
                                    <label for="form-city">Ville</label>
                                    <input type="text" name="town" value="{{old('town', $user->town)}}" class="form-control @error('town') is-invalid @enderror" id="form-city">
                                    @error('town')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label for="form-zip">Code Postal</label>
                                    <input type="text" value="{{old('cp', $user->cp)}}" class="form-control @error('cp') is-invalid @enderror" name="cp" id="form-zip">
                                    @error('cp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-12 col-md-4">
                                    <label for="departement">Département</label>
                                    <input type="text" value="{{old('departement', $user->departement)}}" class="form-control @error('departement') is-invalid @enderror" name="departement" id="departement">
                                    @error('departement')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-12 col-md-12">
                                    <label for="email">Adresse de messagerie<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{old('lastname', $user->email)}}">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('profil', Auth::user()) }}" class="btn btn-secondary mt-3"><i class="fas fa-times text-light"></i> Annuler</a>
                                <button type="submit" class="btn btn-primary mt-3"><i class="far fa-paper-plane text-light"></i>  Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <form action="{{ route('change.password', Auth::user()) }}" method="post" id="identicalForm" >
                    @csrf
                    <div class="text-center mb-3">
                        <h3>CHANGEMENT DE MOT DE PASSE</h3>
                    </div>
                    <div class="form-row">
                      <div class="col-md-6 col-sm-12 mb-4">
                          <div class="input-group" id="show_hide_password_1">
                              <input id="password" placeholder="Mot de passe" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                              <div class="input-group-append">
                                  <span class="input-group-text"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                              </div>
                              @error('password')
                                  <span class="invalid-feedback text-danger" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
                      <div class="col-md-6 col-sm-12 mb-4">
                          <div class="input-group" id="show_hide_password_2">
                              <input id="password-confirm" placeholder="Confirmer le mot de passe" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                              <div class="input-group-append">
                                  <span class="input-group-text"><a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                              </div>
                              @error('password')
                                  <span class="invalid-feedback text-danger" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success mt-3"></i>Modifier</button>
                    </div>

                </form>
            </div>
        </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <img id="blah" class="mb-3 avatar-modal" src={{ Auth::user()->avatar }}>
                    <!-- Button trigger modal -->
                </div>
                <div class="text-center mb-3">
                    <button type="button" id="upload_link" class="btn btn-sm btn-outline-primary">Modifier la photo</button>
                </div>
                <form action="{{ route('image.upload', Auth::user()) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                <input type="file" id= "upload" name="avatar" onchange="readURL(this);" />
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"><i class="fas fa-times text-secondary"></i> Annuler</button>
                        <button type="submit" class="btn btn-outline-primary"><i class="far fa-paper-plane text-primary"></i>  Envoyer</button>
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

<script>
  (function () {
    var placesAutocomplete = places({
        appId: '{{ env('ALGOLIA_APP_ID') }}',
        apiKey: '{{ env('ALGOLIA_SECRET') }}',
        container: document.querySelector('#form-address'),
        templates: {
            value: function (suggestion) {
            return suggestion.name;
        }
      }
    }).configure({
      type: 'address'
    });
    placesAutocomplete.on('change', function resultSelected(e) {
        let coordonnees = e.suggestion.latlng;

        document.querySelector('#departement').value = e.suggestion.county || '';
        document.querySelector('#form-city').value = e.suggestion.city || '';
        document.querySelector('#form-zip').value = e.suggestion.postcode || '';
    });
  })();
</script>


<script>

$(document).ready(function() {
    $("#show_hide_password_1 a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password_1 input').attr("type") == "text"){
            $('#show_hide_password_1 input').attr('type', 'password');
            $('#show_hide_password_1 i').addClass( "fa-eye-slash" );
            $('#show_hide_password_1 i').removeClass( "fa-eye" );
        }else if($('#show_hide_password_1 input').attr("type") == "password"){
            $('#show_hide_password_1 input').attr('type', 'text');
            $('#show_hide_password_1 i').removeClass( "fa-eye-slash" );
            $('#show_hide_password_1 i').addClass( "fa-eye" );
        }
    });
    $("#show_hide_password_2 a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password_2 input').attr("type") == "text"){
            $('#show_hide_password_2 input').attr('type', 'password');
            $('#show_hide_password_2 i').addClass( "fa-eye-slash" );
            $('#show_hide_password_2 i').removeClass( "fa-eye" );
        }else if($('#show_hide_password_2 input').attr("type") == "password"){
            $('#show_hide_password_2 input').attr('type', 'text');
            $('#show_hide_password_2 i').removeClass( "fa-eye-slash" );
            $('#show_hide_password_2 i').addClass( "fa-eye" );
        }
    });
});

</script>



@endsection
