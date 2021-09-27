@extends('layouts.app')

@section('content')

{{-- --------- Menu du Dashboard-------- --}}

@include('admin.header-admin')
<div class="container">
<h2 class="text-center">Paramètres</h2>
<p>
  <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#departements" aria-expanded="false" aria-controls="collapseExample">
    Départements
  </button>
  <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#categories" aria-expanded="false" aria-controls="collapseExample">
    Catégories
  </button>
  <button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#budgets" aria-expanded="false" aria-controls="collapseExample">
    Budgets
  </button>
</p>
<div class="collapse" id="departements">
  <div class="card card-body">
    <h3>Départements</h3>
    <table class="table table-striped">
      <div>
        <!-- Button trigger modal départements-->
      <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#modalDepartements">
        Ajouter un département
      </button>
      </div>
      <tbody>
        @foreach ($departements as $departement)
          <tr>
            <td>{{ $departement->name }}</td>
            <td><a class="btn btn-danger" href="#">Supprimer</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div class="collapse" id="categories">
  <div class="card card-body">
    <h3>Catégories</h3>
    <table class="table table-striped">
      <div>
        <!-- Button trigger modal catégories-->
      <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#modalCategories">
        Ajouter une catégorie
      </button>
      </div>
      <tbody>
        @foreach ($categories as $categorie)
          <tr>
            <td>{{ $categorie->name }}</td>
            <td><a class="btn btn-danger" href="#">Supprimer</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<div class="collapse" id="budgets">
  <div class="card card-body">
    <h3>Budgets</h3>
    <table class="table table-striped">
      <div>
        <!-- Button trigger modal catégories-->
      <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#modalBudgets">
        Ajouter un budget
      </button>
      </div>
      <tbody>
        @foreach ($budgets as $budget)
          <tr>
            <td>{{ $budget->name }}</td>
            <td><a class="btn btn-danger" href="#">Supprimer</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>


</div>

<div class="modal fade" id="modalDepartements" tabindex="-1" role="dialog" aria-labelledby="modalDepartements" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un département</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ route('admin.departement.create') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-12">
              <input type="text" class="form-control" placeholder="99 - Nom du département" aria-label="name" name="name">
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Enregistrer</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalCategories" tabindex="-1" role="dialog" aria-labelledby="modalCategories" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter une catégorie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalBudgets" tabindex="-1" role="dialog" aria-labelledby="modalBudgets" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ajouter un budget</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

@endsection
