@extends('layouts.app')


@section('title')
  Enregistrement des annonces | RYT
@endsection


@section('content')

{{-- --------- Menu du Dashboard-------- --}}

<div class="row">
  <div class="col-md-12">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="dashboard">Tableau De Bord</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="/user-register">Gestion des Utilisateurs <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/projet-register">Gestions des Projets</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Gestion annexe</a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
</div>

<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title text-center"> Gestion des projets</h4>
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                @endif
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class="">
                      <th>Titre</th>
                      <th>Description</th>
                      <th>Budget</th>
                      <th>Client</th>
                      <th>Status</th>
                      <th>Editer</th>
                      <th>Supprimer</th>


                    </thead>
                    <tbody>
                        @foreach ($projets as $projet)
                      <tr>
                        <td> {{ $projet->title }}</td>
                        <td> {{ $projet->description }}</td>
                        <td> {{ $projet->price }} €/jour</td>
                        <td> {{ $projet->user->firstname }} {{ $projet->user->lastname }}  </td>

                        <td>
                          @if($projet->status === 'pending')
                              <i class="far fa-clock icon-admin text-warning "></i>
                          @else
                              <i class="far fa-check-circle icon-admin text-success"></i>
                          @endif
                        </td>
                        <td>
                            <a href="/projet-edit/{{ $projet->id }}" class="btn btn-success">Editer</a>
                        <td>
                            <form action="/projet-delete/{{ $projet->id }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            <input type="hidden" name="id" value=" {{ $projet->id }}">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                            </form>
                          </td>
                      </tr>
                        @endforeach

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

</div>
@endsection

@section('script')
@endsection
