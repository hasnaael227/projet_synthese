@extends('layouts.appem')

@section('content')

<h1>Liste des Étudiants</h1>
<a href="{{ route('etudiants.create') }}">Ajouter</a>
<table>
    <tr>
        <th>Nom</th><th>Prénom</th><th>Email</th><th>Actions</th>
    </tr>
    @foreach($etudiants as $e)
        <tr>
            <td>{{ $e->nom }}</td>
            <td>{{ $e->prenom }}</td>
            <td>{{ $e->email }}</td>
            <td>
                <a href="{{ route('etudiants.show', $e) }}">Voir</a>
                <a href="{{ route('etudiants.edit', $e) }}">Modifier</a>
                <form action="{{ route('etudiants.destroy', $e) }}" method="POST" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

@endsection

