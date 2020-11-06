
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
    <form action="{{ route('article.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

    <!-- ---------------- Titre de l'article ------------------ -->
      <div class="form-group">
        <label for="title">Titre de l'article</label>
      <input type="text" id="title"class="form-control @error('title') is-invalid @enderror" value="{{ $article->title }}" name="title">
        @error('title')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

    <!-- ---------------- Meta description ------------------ -->
      <div class="form-group">
        <label for="description">Meta Description</label>
        <input type="text" id="description"class="form-control @error('description') is-invalid @enderror" value="{{ $article->intro_text }}" name="description">
        @error('description')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

          <!-- ---------------- Key Words ------------------ -->
      <div class="form-group">
        <label for="keywords">Mots clés</label>
        <input type="text" id="keywords"class="form-control @error('keywords') is-invalid @enderror" value="{{ $article->keywords }}" name="keywords">
        @error('keywords')
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
        <textarea class="form-control @error('article') is-invalid @enderror" id="article" rows="5"  name="article">{{ $article->full_text }}</textarea>
        @error('article')
          <div class="invalid-feedback">{{ $message }}</div>
        @enderror
      </div>

    <img src="https://iziplans.s3.eu-west-3.amazonaws.com/documents/{{ $article->filename }}" alt="{{ $article->title }}" class="img-thumbnail">
    <!-- ---------------- Upload ------------------ -->
      <div class="form-group">
        <label for="file">Joindre un fichier</label>
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
