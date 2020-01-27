@extends('layouts.app')



@section('title')
    Dashboard | Iziplans
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
            <a class="nav-link" href="user-register">Gestion des Utilisateurs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="projet-register">Gestions des Projets</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Donneés annexes</a>
          </li>          
        </ul>
      </div>
    </nav>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
          <h4 class="card-title text-center">Données utilisateurs</h4>
      </div>

      <table class="table">
        <tbody>

          <tr>      
            <th class="">Date de la dernière inscription</th>
            @foreach ( $lastuser as $last)          
            <td>{{ date('d/m/Y H:i:s', strtotime($last->created_at)) }}</td>
            @endforeach
          </tr>

          <tr>
            <th class=""><strong>Nombre total d'utilisateurs</strong></th>          
            <td class="text-left"><strong>{{ $users->count() }}</strong></td>
          </tr>

          <tr>
            <th class="">Nombre total d'administrateurs</th>          
            <td class="text-left">{{ $users->where('role', 'admin')->count()}}</td>
          </tr> 

          <tr>
            <th class="">Nombre total de freelances</th>          
            <td>{{ $users->where('role', 'freelance')->count()}}</td>
          </tr> 

          <tr>
            <th class="">Nombre total de clients</th>          
            <td>{{ $users->where('role', 'client')->count()}}</td>
          </tr>                        
        </tbody>
      </table>  
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
          <h4 class="card-title text-center">Données projets</h4>
      </div>

      <table class="table">
        <tbody>

          <tr>      
            <th class="">Date du dernier projet</th>
            @foreach ( $lastprojet as $last)          
            <td>{{ date('d/m/Y H:i:s', strtotime($last->created_at)) }}</td>
            @endforeach
          </tr>

          <tr>
            <th class="">Nombre total de projets</th>          
            <td><strong>{{ $projets->count()}}</strong></td>
          </tr>       
                             
        </tbody>
      </table>  
    </div>
  </div>

</div>


@endsection

@section('script')

@endsection
