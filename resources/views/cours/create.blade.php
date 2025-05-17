@extends('layouts.appem')

@section('content')
<div class="container mt-5">
    <h2>Ajouter un nouveau cours</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <form action="{{ route('cours.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf

        <div class="mb-3">
            <label for="formateur" class="form-label">Formateur</label>
            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
            <input type="hidden" name="formateur_id" value="{{ auth()->user()->id }}">
        </div>

        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="contenu" class="form-label">Contenu</label>
            <textarea name="contenu" rows="4" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="type_pdf" class="form-label">Fichier PDF</label>
            <input type="file" name="type_pdf" class="form-control">
        </div>

        <div class="mb-3">
            <label for="type_video" class="form-label">Vidéo</label>
            <input type="file" name="type_video" class="form-control">
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Catégorie</label>
            <select name="category_id" id="category-select" class="form-select" required>
                <option value="">Choisir une catégorie</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
            <label for="chapitre_id" class="form-label">Chapitre</label>
            <select name="chapitre_id" id="chapitre-select" class="form-select" required>
                <option value="">Choisir un chapitre</option>
            </select>
        </div><br><br>

        <button type="submit" class="btn btn-primary">Ajouter le cours</button>
    </form>
</div>

<script>
document.getElementById('category-select').addEventListener('change', function() {
    const categoryId = this.value;
    const chapitreSelect = document.getElementById('chapitre-select');

    // Clear chapitre select if no category selected
    if (!categoryId) {
        chapitreSelect.innerHTML = '<option value="">Choisir un chapitre</option>';
        return;
    }

    fetch(`/chapitres-by-categorie/${categoryId}`)
        .then(response => response.json())
        .then(chapitres => {
            let options = '<option value="">Choisir un chapitre</option>';
            chapitres.forEach(chapitre => {
                options += `<option value="${chapitre.id}">${chapitre.titre}</option>`;
            });
            chapitreSelect.innerHTML = options;
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des chapitres :', error);
            chapitreSelect.innerHTML = '<option value="">Erreur chargement</option>';
        });
});
</script>
@endsection
