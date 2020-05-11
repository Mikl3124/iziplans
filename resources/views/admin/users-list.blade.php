@extends('layouts.app')

@section('content')

{{-- --------- Menu du Dashboard-------- --}}

@include('admin.header-admin')

<div class="row">
          <div class="col-md-12">
            <div class="card mt-2">
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
                      <th>Dernière Connection</th>
                      <th>Connections</th>
                      <th>Rôle</th>
                      <th>Nbre d'annonces</th>
                      <th>Editer</th>
                      <th>Supprimer</th>
                      <th>Se connecter</th>
                    </thead>
                    <tbody>                        
                              

                        @foreach ($users as $user)
                      <tr>                        
                        <td> {{ $user->lastname }}</td>
                        <td> {{ $user->firstname }}</td>
                        <td> 
                          <div>{{ $user->email }}</div>
                          <div>
                            @if ($user->subscription('abonnement'))
                              " {{ ($user->subscription('abonnement')->stripe_status) }} "
                            @endif
                          </div>                        
                        </td>
                        <td> 
                          @if ($user->last_login_at)
                            {{Carbon\Carbon::parse($user->last_login_at)->diffForHumans()}}
                          @else 
                            Jamais connecté
                          @endif
                        </td>
                        <td> 
                          @if ($user->number_of_connections)
                            {{ $user->number_of_connections }}
                          @else 
                            0
                          @endif
                        </td>
                        <td> {{ $user->role }}</td>
                        <td class="text-center">
                          <a class="nav-link" href="{{ route('admin.projets.by.user', $user) }}">{{ $user->projets->count() }} projet(s) 
                          <a class="nav-link" href="{{ route('admin.offers.by.user', $user) }}">{{ $user->offers->count() }} offre(s)
                        </td>                                               
                        <td>
                        <a href="{{ route('admin.user.edit',$user->id)}}" class="btn btn-primary">Editer</a>
                        <td>
                        <form action="{{ route('admin.user.delete', $user->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                          <input type="hidden" name="id" value=" {{ $user->id }}">
                          <button type="submit" class="btn btn-danger" onclick="return confirm('Etes vous sûr de vouloir supprimer cet utilisateur?');">Supprimer</button>     
                        </form>

                        </td>
                        <td><a class="btn btn-primary mb-2" href="{{ route('admin.connect_as', $user)}}">Se connecter</a></t>
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