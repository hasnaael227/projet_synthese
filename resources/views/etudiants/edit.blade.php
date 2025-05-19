@extends('layouts.appETU')

@section('content')
<h1>Modifier Étudiant</h1>
<form action="{{ route('etudiants.update', $etudiant) }}" method="POST">
    @csrf @method('PUT')
    <input type="text" name="nom" value="{{ $etudiant->nom }}"><br>
    <input type="text" name="prenom" value="{{ $etudiant->prenom }}"><br>
    <input type="text" name="numTel" value="{{ $etudiant->numTel }}"><br>
    <input type="email" name="email" value="{{ $etudiant->email }}"><br>
    <button type="submit">Modifier</button>
</form>
@endsection