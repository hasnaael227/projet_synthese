@extends('layouts.app')

@section('content')
<style>
    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #2c3e50;
    }
    a.button-create {
        display: inline-block;
        margin-bottom: 15px;
        padding: 10px 15px;
        background-color: #3490dc;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    a.button-create:hover {
        background-color: #2779bd;
    }
    .success-message {
        background-color: #d4edda;
        color: #155724;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        border: 1px solid #c3e6cb;
        width: fit-content;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px 15px;
        text-align: center;
    }
    th {
        background-color: #3490dc;
        color: white;
        font-weight: bold;
    }
    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
    a.action-link {
        margin: 0 5px;
        color: #3490dc;
        text-decoration: none;
        font-weight: 600;
    }
    a.action-link:hover {
        text-decoration: underline;
    }
    form.delete-form {
        display: inline;
    }
    button.delete-btn {
        background: none;
        border: none;
        color: #e3342f;
        cursor: pointer;
        font-weight: 600;
        padding: 0 5px;
        font-size: 1em;
    }
    button.delete-btn:hover {
        text-decoration: underline;
    }
</style>

<h1>Liste des Chapitres</h1>

<a href="{{ route('chapitres.create') }}" class="button-create">Créer un nouveau chapitre</a>

@if(session('success'))
    <div class="success-message">{{ session('success') }}</div>
@endif

<table>
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
    <a href="{{ route('chapitres.show', $chapitre->id) }}" class="btn btn-primary btn-sm" title="Voir">Voir</a>
    <a href="{{ route('chapitres.edit', $chapitre->id) }}" class="btn btn-success btn-sm" title="Éditer">Éditer</a>
    <form action="{{ route('chapitres.destroy', $chapitre->id) }}" method="POST" onsubmit="return confirm('Supprimer ce chapitre ?')" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm" title="Supprimer">Supprimer</button>
    </form>
</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
