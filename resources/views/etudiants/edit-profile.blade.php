@extends('layouts.appETU')

@section('content')
<div class="container mt-5">
    <h2>Modifier Mon Profil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('etudiants.update', $etudiant->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $etudiant->nom) }}">
        </div>

        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ old('prenom', $etudiant->prenom) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Adresse Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $etudiant->email) }}">
        </div>

        <div class="mb-3">
            <label for="numTel" class="form-label">Téléphone</label>
            <input type="text" name="numTel" class="form-control" value="{{ old('numTel', $etudiant->numTel) }}">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe (laisser vide si inchangé)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection
