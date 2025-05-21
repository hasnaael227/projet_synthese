@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Payer une catégorie</h2>

<form action="{{ route('paiements.store') }}" method="POST">
    @csrf

    {{-- Nom catégorie (readonly) --}}
    <div class="mb-3">
        <label>Nom de la catégorie</label>
        <input type="text" class="form-control bg-light text-secondary" value="{{ $categorie->name ?? 'Non défini' }}" readonly>
        <input type="hidden" name="category_id" value="{{ $categorie->id ?? '' }}">
    </div>

    {{-- Prix (readonly) --}}
    <div class="mb-3">
        <label>Prix</label>
        <input type="text" class="form-control bg-light text-secondary" value="{{ $categorie->prix ?? 'Non défini' }}" readonly>
    </div>

    {{-- Ajouter l'input caché pour l'id étudiant --}}
    <input type="hidden" name="etudiant_id" value="{{ $etudiant->id ?? '' }}">

    {{-- Champs paiement --}}
    <div class="mb-3">
        <label>CIN</label>
        <input type="text" name="cin" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Numéro de carte</label>
        <input type="text" name="numero_carte" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Date d'expiration</label>
        <input type="month" name="date_expiration" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Code de sécurité</label>
        <input type="text" name="code_securite" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Payer maintenant</button>
</form>
</div>

<script>
    // JS pour mettre à jour nom et prix de la catégorie au changement de sélection
document.getElementById('categorySelect').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const categoryName = selectedOption.text.trim();
    const categoryPrice = selectedOption.getAttribute('data-prix') || '';

    document.getElementById('categoryName').value = (categoryName && categoryName !== '-- Sélectionner --') ? categoryName : '';
    document.getElementById('categoryPrice').value = categoryPrice;
});
</script>
@endsection
