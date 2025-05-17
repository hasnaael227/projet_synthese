@extends('layouts.app')

@section('content')
<style>
    h1 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 25px;
    }
    form {
        max-width: 500px;
        margin: 0 auto;
        background-color: #f7fafc;
        padding: 25px 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #34495e;
    }
    input[type="text"],
    select {
        width: 100%;
        padding: 10px 12px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1em;
        box-sizing: border-box;
        transition: border-color 0.3s ease;
    }
    input[type="text"]:focus,
    select:focus {
        border-color: #3490dc;
        outline: none;
    }
    button {
        background-color: #3490dc;
        color: white;
        padding: 12px 20px;
        font-size: 1em;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 600;
        width: 100%;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #2779bd;
    }
    .error-list {
        max-width: 500px;
        margin: 0 auto 20px auto;
        background-color: #ffe6e6;
        border: 1px solid #f5c6cb;
        color: #721c24;
        padding: 15px 20px;
        border-radius: 6px;
    }
    .error-list ul {
        margin: 0;
        padding-left: 20px;
    }
</style>

<h1>Créer un Chapitre</h1>

@if ($errors->any())
    <div class="error-list">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('chapitres.store') }}" method="POST">
    @csrf
    <label for="titre">Titre:</label>
    <input type="text" name="titre" id="titre" value="{{ old('titre') }}" required>

    <label for="category_id">Catégorie:</label>
    <select name="category_id" id="category_id" required>
        <option value="">--Choisir une catégorie--</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    <button type="submit">Créer</button>
</form>
@endsection
