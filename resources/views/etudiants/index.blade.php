@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h1>Liste des étudiants</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($etudiants as $etudiant)
                <tr>
                    <td>{{ $etudiant->nom }}</td>
                    <td>{{ $etudiant->email }}</td>
                    <td>
                        <a href="{{ url('/paiements/create?etudiant_id=' . $etudiant->id) }}" class="btn btn-sm btn-primary">
                            Créer un paiement
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
