@extends('layouts.app')

@section('title', 'Modifier la catégorie')

@section('content')
    <h1>Modifier la catégorie</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nom <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" id="name" required value="{{ old('name', $category->name) }}">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="prix" class="form-label">Prix</label>
            <input type="number" step="0.01" class="form-control" name="prix" id="prix" value="{{ old('prix', $category->prix) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Image actuelle</label><br>
            @if ($category->image)
                <img src="{{ asset($category->image) }}" alt="Image" width="150" class="mb-2">
            @else
                <p>Aucune image</p>
            @endif
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Changer l'image</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
@endsection
