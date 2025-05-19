@extends('layouts.appETU')

@section('content')
<h1>Créer Étudiant</h1>
<form action="{{ route('etudiants.store') }}" method="POST">
    @csrf
    <input type="text" name="nom" placeholder="Nom"><br>
    <input type="text" name="prenom" placeholder="Prénom"><br>
    <input type="text" name="numTel" placeholder="Numéro de téléphone"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Mot de passe"><br>
    <button type="submit">Enregistrer</button>
</form>
@endsection