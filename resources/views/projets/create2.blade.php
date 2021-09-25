@extends('layouts.app')

@section('content')

  <div class="text-center bg-primary py-4 mb-5">
    <h1 class="text-white">Poster une mission Beta</h1>
  </div>

  <div class="container">
    <form id="regForm" action="{{ route('projet.store2') }}" method="POST" enctype="multipart/form-data">
        @csrf
    <!-- ---------------- Titre de la mission ------------------ -->
      <div class="form-group select2-selection">
        <label for="title-projet">Titre de votre mission </label>
      <input type="text" id="title-projet"class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" name="title">
        @error('title')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    <!-- ---------------- Compétences ------------------ -->
      <div class="row">
        <!-- ---------------- Catégories ------------------ -->
        <div class="col-md-12 col-sm-12">
            <div class="form-group">
              <label for="categories-projet">Selectionnez vos catégories</label>
              <select class="form-control js-select @error('categories') is-invalid @enderror" id="categories-projet" value="{{ json_encode(old('categories')) }}" multiple="multiple" name="categories[]">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ in_array($category->id, old('categories') ?: []) ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
              </select>
              @error('categories')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
        </div>

      </div>
    <!-- ---------------- Description ------------------ -->
      <div class="form-group">
        <label for="description-projet">Décrivez les tâches que vous souhaitez confier :</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description-projet" rows="5"  name="description">{{ old('description') }}</textarea>
        @error('description')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    <!-- ---------------- Budget ------------------ -->
      <div class="form-group">
        <label for="budget-projet">Selectionnez votre budget</label>
        <select class="form-control @error('budget') is-invalid @enderror" id="budget-projet" value="1" name="budget">
          @foreach ($budgets as $budget)
          <option value="{{ $budget->id}}" {{ ( old("budget") == $budget->id ? "selected":"") }}>{{ $budget->name }}</option>
          @endforeach
          </select>
        @error('budget')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    <!-- ---------------- Département ------------------ -->
      <div class="form-group">
        <label for="departements">Selectionnez le departement</label>
        <select class="form-control @error('departement') is-invalid @enderror" id="departement-projet" value="{{ old('departement')}}" name="departement">
          @foreach ($departements as $departement)
            <option value="{{ $departement->id}}" {{ ( old("departement") == $departement->id ? "selected":"") }}>{{ $departement->name }}</option>
          @endforeach
        </select>
        @error('departements')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    <!-- ---------------- Upload ------------------ -->
      <div class="form-group">
        <label for="file-projet">Joindre un fichier (optionnel)</label>
        <input type="file" class="form-control-file @error('file_projet') is-invalid @enderror" id="file-projet" value="{{ old('file-projet') }}" name="file_projet">
        @error('file_projet')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    <!-- ---------------- Submit ------------------ -->
      <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Valider
        </button>
        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Votre adresse e-mail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="email" id="email" class="form-control" name="email">
        <h2 id="result"></h2>
      </div>
      <div class="modal-footer">
        <button id="validate-btn" type="submit" class="btn btn-success" disabled >Poster la mission</button>
      </div>
    </div>
  </div>
</div>

    </form>
  </div>


  <script>
  $(document).ready(function() {
      $('.js-select').select2();
  });
  </script>

  <script>
  function validateEmail(email) {
  const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function validate() {
  const $result = $("#result");
  const email = $("#email").val();
  var validateButton = document.getElementById("validate-btn");
  $result.text("");

  if (validateEmail(email)) {
    console.log('coco1');
    validateButton.disabled = false;

  } else {
    console.log('coco2');
    validateButton.disabled = true;

  }
  return false;
}

$("#email").on("input", validate);
  </script>

@endsection
