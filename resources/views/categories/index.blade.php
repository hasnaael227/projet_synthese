@extends('layouts.app')

@section('title', 'Liste des catégories')

@section('content')
    <h1>Liste des catégories</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('categories.create') }}" class="btn btn-success mb-3">Ajouter une catégorie</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>{{ $category->prix ? number_format($category->prix, 2) . ' DH' : '-' }}</td>
                    <td>
                            @if ($category->image)
                                <img src="{{ asset('images/categories/' . $category->image) }}" alt="NOOO Image" width="100">
                            @else
                                <span class="text-muted">Aucune</span>
                            @endif

                    </td>
                    <td>
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-info">Voir</a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-primary">Modifier</a>
                <td>{{ $categorie->nom }}</td>
<td>
    @foreach ($categories as $categorie)
        <div style="margin-bottom: 10px;">
            <span>{{ $categorie->nom }}</span>
            <form action="{{ route('paiement.payer', $categorie->id) }}" method="POST">
    @csrf
    <button type="submit">Payer</button>
</form>
        </div>
    @endforeach
</td>

                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
