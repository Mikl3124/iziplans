@extends('layouts.app')

@section('content')

  <div class="text-center bg-primary py-4 mb-5">
    <h1 class="text-white">Poster une mission</h1>
  </div>

  <div class="container">
    <form id="regForm" action="{{ route('projet.store') }}" method="POST" enctype="multipart/form-data">
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
        <textarea class="form-control @error('description') is-invalid @enderror" id="description-projet" rows="5" name="description">{{ old('description') }} </textarea>
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
    <!-- ---------------- Submit ------------------ -->
      <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
  </div>


  <script>
  $(document).ready(function() {
      $('.js-select').select2();
  });
  </script>

@endsection

