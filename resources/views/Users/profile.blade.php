@extends('layouts.app')
@section('content')

<div class="container mt-5">
    <h2>Profil Admin</h2>
    <a href="{{ route('users.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion
    </a>
    <form id="logout-form" action="{{ route('users.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Informations personnelles</h5>
            <div class="mb-3">
                <li><a href="{{ route('users.profile') }}"> <i class="fa-regular fa-address-card"></i> Mon Profil</a></li>
                @if($user->image)
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/' . $user->image) }}" alt="Image de {{ $user->name }}" class="img-fluid rounded" style="max-width: 200px;">
                    </div>
                @else
                    <p>Aucune image disponible.</p>
                @endif
                <p><strong>Matricule:</strong> {{ $user->matricule }}</p>
                <p><strong>Nom:</strong> {{ $user->name }}</p>
                <p><strong>prenom:</strong> {{ $user->prename}}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Rôle:</strong> {{ $user->role }}</p>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('users.editProfile') }}" class="btn btn-primary">Modifier le Profil</a>
                <a href="{{ route('users.change_password') }}" class="btn btn-secondary">Changer le Mot de Passe</a>
            </div>
        </div>
    </div>
</div>
@endsection
