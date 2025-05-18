@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un cours au chapitre : <strong>{{ $chapitre->titre }}</strong></h1>

    {{-- Affichage des messages de succès --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

        {{-- Nom du chapitre en readonly avec fond gris --}}
    <div class="mb-3">
        <label for="chapitre_titre" class="form-label">Chapitre</label>
        <input type="text" id="chapitre_titre" class="form-control" value="{{ $chapitre->titre }}" readonly
            style="background-color: #e9ecef; color: #495057;">
    </div>

    {{-- Nom de la catégorie en readonly avec fond gris --}}
    <div class="mb-3">
        <label for="category_name" class="form-label">Catégorie</label>
        <input type="text" id="category_name" class="form-control" value="{{ $chapitre->category->name }}" readonly
            style="background-color: #e9ecef; color: #495057;">
    </div>
    {{-- Liste des cours déjà associés --}}
<h4>Cours déjà dans ce chapitre :</h4>
@if($existingCours->isEmpty())
    <p>Aucun cours associé pour le moment.</p>
@else
    <ul class="list-group">
        @foreach($existingCours as $cours)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $cours->titre }} 
                
            <form action="{{ route('chapitres.removeCourse', [$chapitre->id, $cours->id]) }}" method="POST" style="margin:0;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Voulez-vous vraiment supprimer ce cours du chapitre ?');">
                    Supprimer
                </button>
            </form>
            </li>
        @endforeach
    </ul>
@endif


    {{-- Formulaire pour ajouter un cours --}}
    <form action="{{ route('chapitres.addCourse', $chapitre->id) }}" method="POST">
        @csrf
<div class="form-group">
    <label for="cours_id">Sélectionnez un cours à ajouter  :</label>
    <select name="cours_id" id="cours_id" class="form-control" required>
        <option value="">-- Choisir un cours --</option>

        @foreach($availableCourses as $cours)
            <option value="{{ $cours->id }}">{{ $cours->titre }}</option>
        @endforeach

    </select>
    @error('cours_id')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

        <button type="submit" class="btn btn-primary mt-3">Ajouter le cours au chapitre</button>
    </form>

    <a href="{{ route('chapitres.index') }}" class="btn btn-secondary mt-4">Retour à la liste des chapitres</a>
</div>
@endsection
