@extends('layouts.app')

@section('content')

@include('admin.header-admin')

<div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title text-center"> Projets postés par {{ $user->firstname }} {{ $user->lastname }}</h4>
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
                      <th>Projet</th>
                      <th>Budget</th>
                      <th>Client</th>
                      <th>Le</th>
                      <th>Editer</th>
                      <th>Supprimer</th>


                    </thead>
                    <tbody>
                        @foreach ($projets as $projet)
                      <tr>
                        <td>{{ $projet->title }}</td>
                        <td>{{ $projet->budget->name }} /jour</td>
                        <td> <a href="{{ route('admin.user.edit', $projet->user->id) }}"> {{ $projet->user->firstname }} {{ $projet->user->lastname }}  </a></td>
                        <td>{{ date('d/m/Y H:i:s', strtotime($projet->created_at)) }}</td>

                        <td>
                            <a href="{{ route('admin.projet.edit', $projet->id) }}" class="btn btn-success">Editer</a>
                        <td>
                            <form action={{ route('admin.projet.delete', $projet->id) }} method="post">
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
