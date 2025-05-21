<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Paiement #{{ $paiement->id }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- si tu utilises un CSS -->
</head>
<body>

    <h1>Détails du Paiement #{{ $paiement->id }}</h1>

    <ul>
        <li><strong>Étudiant :</strong> {{ $paiement->etudiant->nom ?? 'Étudiant #' . $paiement->etudiant_id }}</li>
        <li><strong>Catégorie :</strong> {{ $paiement->category->name ?? 'Catégorie #' . $paiement->category_id }}</li>
        <li><strong>Prix :</strong> {{ $paiement->category->prix ?? 'N/A' }} DH</li>
        <li><strong>CIN :</strong> {{ $paiement->cin }}</li>
        <li><strong>Numéro de carte :</strong> {{ $paiement->numero_carte }}</li>
        <li><strong>Date d'expiration :</strong> {{ \Carbon\Carbon::parse($paiement->date_expiration)->format('m/Y') }}</li>
        <li><strong>Code sécurité :</strong> {{ $paiement->code_securite }}</li>
        <li><strong>Date de paiement :</strong> {{ $paiement->created_at->format('d/m/Y') }}</li>
    </ul>

    <a href="{{ route('paiements.index') }}">Retour à la liste</a>

</body>
</html>
