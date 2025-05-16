@extends('layouts.app')

@section('content')
    <h1>Créer une nouvelle catégorie</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description"></textarea>

        <button type="submit">Enregistrer</button>
    </form>
@endsection
