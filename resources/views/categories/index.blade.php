@extends('layouts.app')

@section('title', 'Liste des catégories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Liste des Catégories</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-success">➕ Ajouter une catégorie</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($categories->count())
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ Str::limit($category->description, 50) }}</td>
                        <td>
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-info btn-sm">Voir</a>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette catégorie ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">Aucune catégorie trouvée.</div>
    @endif
@endsection
