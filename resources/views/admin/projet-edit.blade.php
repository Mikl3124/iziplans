@extends('layouts.app')

@section('title')
Edition des utilisateurs | RYT
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class ="text-center">Edition des projets</h3>
                    <h4>Projet publié par {{ $projet->user->firstname }} {{ $projet->user->lastname }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="/projet-register-update/{{$projet->id }}" method="POST"  enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                            <div class="form-group">
                                <label>Titre</label>
                                <input type="text" name="title" value="{{ $projet->title }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="description" value="{{ $projet->description }}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Budget</label>
                                <input type="number" name="budget" value="{{ $projet->budget }}" class="form-control">
                            </div>

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
                            {{-- ------------------- Status --------------------- --}}
                            <div class="form-group">
                                <select name="status" class="custom-select mr-sm-2">
                                    <option value="pending"  {{ old('status', $projet->status) == 'pending' ? 'selected' : '' }}>
                                        En attente
                                    </option>
                                    <option value="publish" {{ old('status', $projet->status) == 'publish' ? 'selected' : '' }}>
                                        Publié
                                    </option>

                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Enregistrer la modification</button>
                                <a href="/post-register" type="submit" class="btn btn-danger">Annuler la modification</a>
                            </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function() {
    $('.js-select').select2();
});


$(() => {
    $('input[type="file"]').on('change', (e) => {
        let that = e.currentTarget
        if (that.files && that.files[0]) {
            $(that).next('.custom-file-label').html(that.files[0].name)
            let reader = new FileReader()
            reader.onload = (e) => {
                $('#preview').attr('src', e.target.result)
            }
            reader.readAsDataURL(that.files[0])
        }
    })
})

</script>

@endsection
