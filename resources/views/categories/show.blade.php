@extends('layouts.app')

@section('content')
    <h1>Détails de la Catégorie</h1>

    <p><strong>Nom :</strong> {{ $category->name }}</p>
    <p><strong>Description :</strong> {{ $category->description }}</p>

    <a href="{{ route('categories.index') }}">⬅ Retour à la liste</a>
@endsection
