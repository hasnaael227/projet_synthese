@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Liste des utilisateurs</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
        <i class="fa-solid fa-plus"></i> Ajouter des utilisateurs
    </a>

    <!-- Tableau des utilisateurs -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Image</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->prename }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->image)
                            <img src="{{ Storage::url($user->image) }}" class="img-thumbnail" width="90" alt="Image de profil">
                        @else
                            <img src="{{ asset('images/default-image.png') }}" alt="Image du profil" class="img-thumbnail" width="90">
                        @endif
                    </td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"><i class="far fa-edit"></i></a>
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-success btn-sm" title="Afficher">
                            <i class="fa-regular fa-eye"></i>
                        </a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
