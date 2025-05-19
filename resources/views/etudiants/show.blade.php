@extends('layouts.appETU')

@section('content')
<h1>Détails Étudiant</h1>
<p>Nom : {{ $etudiant->nom }}</p>
<p>Prénom : {{ $etudiant->prenom }}</p>
<p>Email : {{ $etudiant->email }}</p>
<p>Numéro : {{ $etudiant->numTel }}</p>
@endsection