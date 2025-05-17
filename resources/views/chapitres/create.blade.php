@extends('layouts.app')

@section('content')
    <h1>Créer un Chapitre</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color:red;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('chapitres.store') }}" method="POST">
        @csrf
        <label for="titre">Titre:</label><br>
        <input type="text" name="titre" value="{{ old('titre') }}" required><br><br>

        <label for="category_id">Catégorie:</label><br>
        <select name="category_id" required>
            <option value="">--Choisir une catégorie--</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select><br><br>

        <button type="submit">Créer</button>
    </form>
@endsection
