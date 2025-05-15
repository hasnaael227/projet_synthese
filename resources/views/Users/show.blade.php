

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Détails de l'utilisateur</h1>
    
    <div class="card">
        <div class="card-header">
            {{ $user->name }}
        </div>
        <div class="card-body">
            <p><strong>Matricule:</strong> {{ $user->matricule }}</p>
            <p><strong>Nom:</strong> {{ $user->name }}</p>
            <p><strong>Prénom:</strong> {{ $user->prename }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Rôle:</strong> {{ $user->role }}</p>
            @if($user->image)
                <img src="{{ Storage::url($user->image) }}" class="img-thumbnail" width="150" alt="Image de profil">
            @else
                <img src="{{asset('images/default-image.png') }}" alt="Image du projet" class="img-thumbnail" width="90">
            @endif
        </div>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-primary mt-3">Retour à la liste</a>
</div>
@endsection
