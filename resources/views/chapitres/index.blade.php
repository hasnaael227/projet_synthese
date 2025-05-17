@extends('layouts.app')

@section('content')
    <h1>Liste des Chapitres</h1>
    <a href="{{ route('chapitres.create') }}">Créer un nouveau chapitre</a>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chapitres as $chapitre)
                <tr>
                    <td>{{ $chapitre->id }}</td>
                    <td>{{ $chapitre->titre }}</td>
                    <td>{{ $chapitre->category->name }}</td>
                    <td>
                        <a href="{{ route('chapitres.show', $chapitre) }}">Voir</a>
                        <a href="{{ route('chapitres.edit', $chapitre) }}">Éditer</a>
                        <form action="{{ route('chapitres.destroy', $chapitre) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Supprimer ce chapitre ?')" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
