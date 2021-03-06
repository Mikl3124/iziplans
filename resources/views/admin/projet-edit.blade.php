@extends('layouts.app')

@section('content')

@include('admin.header-admin')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card mt-2">
                <div class="card-header">
                    <h3 class ="text-center">Edition du projet</h3>
                <h4>Projet publié par <a href="{{ route('admin.user.edit', $projet->user->id) }}"> {{ $projet->user->firstname }} {{ $projet->user->lastname }}</a></h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('admin.projet.update', $projet->id) }}" method="POST"  enctype="multipart/form-data" >
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label>Date de création</label>
                                    <input placeholder="{{ Carbon\Carbon::parse($projet->created_at)->format('d-m-Y')}}" name='entry_date' class="form-control" type="text" onfocus="(this.type='date')">
                                </div>
                                
                                <div class="form-group">
                                    <label>Titre</label>
                                    <input type="text" name="title" value="{{ $projet->title }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" rows="5">{{ $projet->description }}</textarea>
                                </div>
                                {{-- ------------------- Budget --------------------- --}}
                                <div class="form-group">
                                <label for="budget-projet">Selectionnez votre budget</label>
                                    <select class="form-control @error('budget') is-invalid @enderror" id="budget-projet" value = "{{ old('budget') }}"  name="budget">
                                        @foreach ($budgets as $budget)
                                            <option value="{{ $budget->id}}" {{ ( $projet->budget->id == $budget->id ? "selected":"") }}>{{ $budget->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- ------------------- Departement --------------------- --}}
                                <div class="form-group">
                                    <label for="departements">Selectionnez le departement</label>
                                    <select class="form-control" id="departement-projet" value="{{ old('departement')}}" name="departement">
                                        @foreach ($departements as $departement)
                                        <option value="{{ $departement->id}}" {{ ( $projet->departement->id == $departement->id ? "selected":"") }}>{{ $departement->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- ------------------- Catégories --------------------- --}}
                                <div class="form-group">
                                    <label for="categories-projet">Selectionnez vos catégories</label>
                                    <select class="form-control js-select @error('categories') is-invalid @enderror" id="categories-projet" value="{{ json_encode(old('categories')) }}" multiple="multiple" name="categories[]">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ in_array($category->id, $projet->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                    @endforeach
                                    </select>
                                </div>
                                {{-- ------------------- Status --------------------- --}}
                                <div class="form-group">
                                    <select name="status" class="custom-select mr-sm-2">
                                        <option value="pending"  {{ old('status', $projet->status) == 'pending' ? 'selected' : '' }}>
                                            En attente
                                        </option>
                                        <option value="open" {{ old('status', $projet->status) == 'open' ? 'selected' : '' }}>
                                            Publié
                                        </option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Enregistrer la modification</button>
                                </div>
                            </form>
                            <form  action="{{ route('admin.projet.validate') }}" method="post">
                                @csrf
                                <input type="hidden" name="projet_id" value= {{$projet->id}}>
                                @if ($projet->status === "pending")
                                    <button type="submit" class="btn btn-primary">Valider le projet</button>
                                @elseif ($projet->status === "open")
                                    <button type="submit" class="btn btn-danger">Suspendre le projet</button>
                                @endif                                
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
