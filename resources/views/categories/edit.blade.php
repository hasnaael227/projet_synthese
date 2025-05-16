@extends('layouts.app')

@section('content')
    <h1>Modifier la catégorie</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nom :</label>
        <input type="text" name="name" id="name" value="{{ $category->name }}" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description">{{ $category->description }}</textarea>

        <button type="submit">Mettre à jour</button>
    </form>
@endsection
