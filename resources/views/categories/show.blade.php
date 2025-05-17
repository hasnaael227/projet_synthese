@extends('layouts.app')

@section('title', 'Détails de la catégorie')

@section('content')
    <div class="container">
        <h1>Détails de la catégorie</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h3 class="card-title">{{ $category->name }}</h3>

                @if ($category->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $category->image) }}" alt="Image" style="max-width: 200px;">
                    </div>
                @else
                    <p class="text-muted">Aucune image disponible.</p>
                @endif

                <p><strong>Description :</strong> {{ $category->description ?? 'Aucune' }}</p>
                <p><strong>Prix :</strong> {{ $category->prix ? $category->prix . ' DH' : 'Non spécifié' }}</p>

                <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">Modifier</a>
                <a href="{{ route('categories.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
@endsection
