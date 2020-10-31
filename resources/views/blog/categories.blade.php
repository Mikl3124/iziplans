@extends('layouts.app')

@section('content')
  <div class="container">
    <ul class="list-group mt-5">
      @foreach ($categories as $category)
          <div class="list-group-item">
            <div class="d-flex justify-content-between">
              <p>{{ $category->title }}</p>
              <a class="btn btn-danger" href="http://">Supprimer</a>
            </div>

          </div>
      @endforeach
    </ul>

    <div class="mt-3">
      <form action="{{ route('categorie.store') }}" method="POST">
          @csrf
        <div class="form-group">
          <label for="title">Ajouter une catégorie</label>
            <input type="text" id="title"class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" name="title">
          @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
      </div>

    <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
</div>



@endsection
