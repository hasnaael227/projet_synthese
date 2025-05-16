@extends('layouts.app')

@section('title', 'Détails de la catégorie')

@section('content')
    <h1>Détails de la catégorie</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $category->name }}</h5>
            <p class="card-text">{{ $category->description ?? 'Pas de description.' }}</p>
        </div>
    </div>

    <a href="{{ route('categories.index') }}" class="btn btn-link mt-3">⬅ Retour à la liste</a>
@endsection
