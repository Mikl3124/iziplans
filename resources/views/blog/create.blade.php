
@extends('layouts.app')

@section('content')

  <!-- Tiny Editor  -->
  <script src='https://cdn.tiny.cloud/1/d4edgvbtpkw4b8z1qtao2khy8em9ljzsbjmjp77n255jrnhf/tinymce/5/tinymce.min.js' referrerpolicy="origin">
  </script>

  <script>
    tinymce.init({
      language : "fr_FR",
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table',
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      height : "580"
    });
  </script>
<div class="container">
  <div class="mt-3">
    <form action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

    <!-- ---------------- Titre de l'article ------------------ -->
      <div class="form-group">
        <label for="title">Titre de votre mission </label>
      <input type="text" id="title"class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" name="title">
        @error('title')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

    <!-- ---------------- Meta description ------------------ -->
      <div class="form-group">
        <label for="description">Meta Description</label>
        <input type="text" id="description"class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" name="description">
        @error('description')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

    <!-- ---------------- Catégories ------------------ -->

      <div class="form-group">
        <label for="categorie">Selectionnez la catégorie</label>
        <select class="form-control" id="categorie" name="categorie">
          @foreach ($categories as $category)
              <option value="{{ $category->title }}" {{ in_array($category->id, old('categories') ?: []) ? 'selected' : '' }}>{{ $category->title }}</option>
          @endforeach
        </select>
      </div>

    <!-- ---------------- Article ------------------ -->

      <div class="form-group">
        <textarea class="form-control @error('article') is-invalid @enderror" id="article" rows="5"  name="article">{{ old('article') }}</textarea>
        @error('article')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

    <!-- ---------------- Upload ------------------ -->
      <div class="form-group">
        <label for="file">Joindre un fichier (optionnel)</label>
        <input type="file" class="form-control-file @error('file') is-invalid @enderror" id="file" value="{{ old('file') }}" name="file">
        @error('file')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>
    <!-- ---------------- Submit ------------------ -->
      <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
  </div>

  </div>

</div>


@endsection
