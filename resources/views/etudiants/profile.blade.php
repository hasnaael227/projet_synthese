@extends('layouts.appETU')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Mon Profil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <p><strong>Nom :</strong> {{ $etudiant->nom }}</p>
            <p><strong>Prénom :</strong> {{ $etudiant->prenom }}</p>
            <p><strong>Email :</strong> {{ $etudiant->email }}</p>
            <p><strong>Téléphone :</strong> {{ $etudiant->numTel }}</p>

            <a href="{{ route('etudiant.edit-profile') }}" class="btn btn-primary mt-3">Modifier mon profil</a>
        </div>
    </div>
</div>
@endsection
