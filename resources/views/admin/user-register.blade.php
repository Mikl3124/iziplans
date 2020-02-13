@extends('layouts.app')


@section('title')
  Enregistrement des rôles | RYT
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
            <a class="nav-link" href="user-register">Gestion des Utilisateurs <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="projet-register">Gestions des projets</a>
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
                <h4 class="card-title text-center"> Gestion des utilisateurs</h4>
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                        </div>
                @endif
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">                      
                      <th>Nom</th>
                      <th>Prénom</th>
                      <th>Email</th>
                      <th>Rôle</th>
                      <th>Nombre d'annonces</th>
                      <th>Editer</th>
                      <th>Supprimer</th>


                    </thead>
                    <tbody>                        
                              

                        @foreach ($users as $user)
                      <tr>                        
                        <td> {{ $user->lastname }}</td>
                        <td> {{ $user->firstname }}</td>
                        <td> {{ $user->email }}</td>

                        <td>                 
                        <?php switch ($user->role) {
                                case 'customer':
                                  echo'Client';
                                  break;
                                case 'admin':
                                  echo"Administrateur";
                                  break;
                                case 'client':
                                  echo "Client";
                                  break;
                                case 'freelance':
                                  echo "Freelance";
                                  break;                    
                                default:
                                  echo"aucun";
                                    break;
                          } ?>
                          </td>
                          <td class="text-center">
                              <a class="nav-link" href="/projet-by-user/{{ $user->id }}">Voir</a>
                          </td>                                               
                          <td>
                              <a href="/user-edit/{{ $user->id }}" class="btn btn-success">Editer</a>
                          <td>
                              <form action="/user-delete/{{ $user->id }}" method="post">
                                  {{ csrf_field() }}
                                  {{ method_field('DELETE') }}
                              <input type="hidden" name="id" value=" {{ $user->id }}">
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

<script>

console.log($('#tri'));
  


if ($('#tri').val("1") == "Croissant") {
  $users = $usersinc;
} else if ($('#tri').val("2") == "Décroissant") {
  $users = $usersdesc;
}

</script>