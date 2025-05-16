@extends('layouts.app')

@section('content')
    <h1>Liste des Catégories</h1>

    @if(session('success'))
        <div style="color: green">{{ session('success') }}</div>
    @endif

    <a href="{{ route('categories.create') }}">➕ Ajouter une catégorie</a>

    <ul>
        @foreach($categories as $category)
            <li>
                <strong>{{ $category->name }}</strong>  
                <a href="{{ route('categories.show', $category) }}">Voir</a> | 
                <a href="{{ route('categories.edit', $category) }}">Modifier</a> |
                <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Supprimer cette catégorie ?')">🗑️ Supprimer</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
