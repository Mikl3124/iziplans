@extends('layouts.app')

@section('content')

  <div class="text-center bg-primary py-4 mb-5">
    <h1 class="text-white">Poster une mission</h1>
  </div>
<div class="container">

 <form id="regForm" action="{{ route('projets.store') }}" method="POST" >
    @csrf

  <div class="form-group">
    <label for="title-projet">Titre de votre mission </label>
  <input type="text" id="title-projet"class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" name="title">
    @error('title')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="row">
    <div class="col md-6 sm-12">
       <div class="form-group">
        <label for="competences-projet">Selectionnez les compétences recherchez</label>
        <select class="form-control js-select @error('competences') is-invalid @enderror" id="competences-projet" multiple="multiple" value="{{ old('competences') }}" multiple="multiple" name="competences[]">
          @foreach ($competences as $competence)
              <option>{{$competence}}</option>
          @endforeach
        
          </select>
        @error('competences')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    </div>
    <div class="col md-6 sm-12">
        <div class="form-group">
          <label for="categories-projet">Selectionnez vos catégories</label>
          <select class="form-control js-select @error('categories') is-invalid @enderror" id="categories-projet" multiple="multiple" name="categories[]">
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


  <div class="form-group">
    <label for="description-projet">Décrivez les tâches que vous souhaitez confier :</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description-projet" rows="5" value="{{ old('description') }}" name="description"></textarea>
    @error('description')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group">
    <label for="budget-projet">Selectionnez votre budget</label>
    <select class="form-control @error('budget') is-invalid @enderror" id="budget-projet" value="{{ old('budget') }}" name="budget">
      @foreach ($budgets as $value=>$budget)
          <option value = {{$value}}>{{$budget}}</option>
      @endforeach
        
      </select>
    @error('budget')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group">
    <label for="lieu-projet">Selectionnez le departement</label>
    <select class="form-control js-select @error('localisation') is-invalid @enderror" id="lieu-projet" value="{{ old('localisation') }}" name="localisation">
      @foreach ($departements as $departement)
        <option>{{$departement}}</option>
      @endforeach
    </select>
    @error('localisation')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-group">
    <label for="file-projet">Joindre un fichier (optionnel)</label>
    <input type="file" class="form-control-file @error('file_projet') is-invalid @enderror" id="file-projet" value="{{ old('file-projet') }}" name="file_projet">
    @error('file_projet')
      <div class="invalid-feedback">{{ $message }}</div>
    @enderror
  </div>



  
  <button type="submit" class="btn btn-primary">Envoyer</button>
</form>


<script>
$(document).ready(function() {
    $('.js-select').select2();
});
</script>



@endsection

