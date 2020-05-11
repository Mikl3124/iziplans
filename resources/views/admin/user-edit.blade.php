@extends('layouts.app')

@section('content')

@include('admin.header-admin')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class ="text-center">Edition de l'utilisateur</h3>
                </div>
                <div class="card-body">
                    <a class="btn btn-primary mb-2" href="{{ route('admin.connect_as', $user)}}">Se connecter en tant que...</a>
                    <div class="row">
                        <div class="col-md-6">
                            <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label>Prénom</label>
                                    <input type="text" name="firstname" value="{{ $user->firstname }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Nom</label>
                                    <input type="text" name="lastname" value="{{ $user->lastname }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>email</label>
                                    <input type="text" name="email" value="{{ $user->email }}" class="form-control">
                                </div>
                                
                                <div class="form-group">
                                    <select name="role" class="custom-select mr-sm-2">
                                        <option value="admin"  {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                            Administrateur
                                        </option>
                                        <option value="client"  {{ old('role', $user->role) == 'client' ? 'selected' : '' }}>
                                            Client
                                        </option>
                                        <option value="freelance"  {{ old('role', $user->role) == 'freelance' ? 'selected' : '' }}>
                                            Freelance
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Enregistrer la modification</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

@endsection