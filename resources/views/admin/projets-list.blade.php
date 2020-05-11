@extends('layouts.app')


@section('content')

{{-- --------- Menu du Dashboard-------- --}}
@include('admin.header-admin')

<div class="row">
  <div class="col-md-12">
    <div class="card mt-2">
      <div class="card-header">
        <h4 class="card-title text-center"> Gestion des projets</h4>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table">
            <thead class="">
              <th>Titre</th>
              <th>Description</th>
              <th>Budget</th>
              <th>Client</th>
              <th>Le</th>
              <th>Offres</th>
              <th>Status</th>
              <th>Editer</th>
              <th>Supprimer</th>


            </thead>
            <tbody>
                @foreach ($projets as $projet)
              <tr>
                <td> {{ $projet->title }}</td>
                <td> {{ $projet->description }}</td>
                <td> {{ $projet->budget->name }} /jour</td>
                <td> {{ $projet->user->firstname }} {{ $projet->user->lastname }}  </td>
                <td>{{ date('d/m/Y', strtotime($projet->created_at)) }}</td> 
                <td> <a href="#">{{ $projet->offers->count() }}</td></a>

                <td>
                  @if($projet->status === 'pending')
                      <i class="far fa-clock icon-admin text-warning "></i>
                  @else
                      <i class="far fa-check-circle icon-admin text-success"></i>
                  @endif
                </td>
                <td>
                    <a href="{{ route('admin.projet.edit', $projet->id) }}" class="btn btn-success">Editer</a>
                <td>
                    <form action="{{ route('admin.projet.delete', $projet->id) }}" method="post">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <input type="hidden" name="id" value=" {{ $projet->id }}">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Etes vous sûr de vouloir supprimer ce projet?');">Supprimer</button>     
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
