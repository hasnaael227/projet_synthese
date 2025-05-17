@extends('layouts.app')

@section('content')
    <h1>Détails du Chapitre</h1>

    <p><strong>ID:</strong> {{ $chapitre->id }}</p>
    <p><strong>Titre:</strong> {{ $chapitre->titre }}</p>
    <p><strong>Catégorie:</strong> {{ $chapitre->category->name }}</p>

    <a href="{{ route('chapitres.index') }}">Retour à la liste</a>
@endsection
