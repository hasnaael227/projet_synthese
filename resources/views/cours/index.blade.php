@extends('layouts.appem')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Liste des cours</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Titre</th>
                <th>Formateur</th>
                <th>Catégorie</th>
                <th>Chapitre</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cours as $cour)
            <tr>
                <td>{{ $cour->titre }}</td>
                <td>{{ $cour->formateur->name }}</td>
                <td>{{ $cour->categorie->name }}</td>
                <td>{{ $cour->chapitre->titre }}</td>
                <td>
                <a href="{{ route('cours.show', $cour) }}" class="btn btn-sm btn-info">Voir</a>
                <a href="{{ route('cours.edit', $cour) }}" class="btn btn-sm btn-primary">Modifier</a>
                    <form action="#" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
