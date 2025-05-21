<!DOCTYPE html>
<html>
<head>
    <title>Liste des Paiements</title>
</head>
<body>

<h1>Liste des Paiements</h1>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

<a href="{{ route('paiements.create') }}">Faire un nouveau paiement</a>

<table border="1" cellpadding="10" cellspacing="0" style="margin-top:20px;">
    <thead>
        <tr>
            <th>ID</th>
            <th>Étudiant</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>CIN</th>
            <th>Numéro de carte</th>
            <th>Date d'expiration</th>
            <th>Code sécurité</th>
            <th>Date</th>
            <th>Détails</th>
        </tr>
    </thead>
    <tbody>
        @foreach($paiements as $paiement)
            <tr>
                <td>{{ $paiement->id }}</td>
                <td>{{ $paiement->etudiant->nom ?? 'Étudiant #' . $paiement->etudiant_id }}</td>
                <td>{{ $paiement->category->name ?? 'Catégorie #' . $paiement->category_id }}</td>
                <td>{{ $paiement->category->prix ?? 'N/A' }} DH</td>
                <td>{{ $paiement->cin }}</td>
                <td>{{ $paiement->numero_carte }}</td>
                <td>{{ \Carbon\Carbon::parse($paiement->date_expiration)->format('m/Y') }}</td>
                <td>{{ $paiement->code_securite }}</td>
                <td>{{ $paiement->created_at->format('d/m/Y') }}</td>
                <td><a href="{{ route('paiements.show', $paiement->id) }}">Voir</a></td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
