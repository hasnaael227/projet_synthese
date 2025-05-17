@extends('layouts.appem')

@section('content')
<div class="container mt-5">
    <h3>Modifier le Cours</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erreurs :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cours.update', $cours->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="titre">Titre :</label>
            <input type="text" name="titre" class="form-control" value="{{ $cours->titre }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="contenu">Contenu :</label>
            <textarea name="contenu" class="form-control" rows="4" required>{{ $cours->contenu }}</textarea>
        </div>

        <div class="form-group mb-3">
            <label for="image">Image :</label><br>
            @if ($cours->image)
                <img src="{{ asset($cours->image) }}" alt="Image actuelle" class="img-thumbnail mb-2" style="max-width: 200px;">
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        <div class="form-group mb-3">
            <label for="type_pdf">Fichier PDF :</label>
            <input type="file" name="type_pdf" class="form-control">
            @if ($cours->type_pdf)
                <small>PDF existant : <a href="{{ asset($cours->type_pdf) }}" target="_blank">Voir</a></small>
            @endif
        </div>

        <div class="form-group mb-3">
            <label for="type_video">Vidéo :</label>
            <input type="file" name="type_video" class="form-control">
            @if ($cours->type_video)
                <small>Vidéo existante : <a href="{{ asset($cours->type_video) }}" target="_blank">Voir</a></small>
            @endif
        </div>

        <div class="form-group mb-3">
            <label for="category_id">Catégorie :</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">-- Sélectionner une catégorie --</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ $cours->category_id == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="chapitre_id">Chapitre :</label>
            <select name="chapitre_id" id="chapitre_id" class="form-control" required>
                @foreach($chapitres as $chapitre)
                    <option value="{{ $chapitre->id }}" {{ $cours->chapitre_id == $chapitre->id ? 'selected' : '' }}>
                        {{ $chapitre->titre }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('cours.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<script>
    document.getElementById('category_id').addEventListener('change', function () {
        const categoryId = this.value;
        fetch(`/chapitres-by-categorie/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                const chapitreSelect = document.getElementById('chapitre_id');
                chapitreSelect.innerHTML = '';
                data.forEach(chapitre => {
                    chapitreSelect.innerHTML += `<option value="${chapitre.id}">${chapitre.titre}</option>`;
                });
            });
    });
</script>
@endsection
