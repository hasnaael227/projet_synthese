@extends('layouts.appem')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Détails du Cours</h4>
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $cours->titre }}</h5>
            <p class="card-text"><strong>Contenu :</strong> {{ $cours->contenu }}</p>

            <p><strong>Catégorie :</strong> {{ $cours->categorie->nom }}</p>
            <p><strong>Chapitre :</strong> {{ $cours->chapitre->titre }}</p>
            <p><strong>Formateur :</strong> {{ $cours->formateur->name }}</p>

            @if($cours->image)
                <p><strong>Image :</strong></p>
                <img src="{{ asset($cours->image) }}" alt="Image du cours" class="img-fluid mb-3" style="max-width: 400px;">
            @endif

            @if($cours->type_pdf)
                <p><strong>Fichier PDF :</strong></p>
                <a href="{{ asset($cours->type_pdf) }}" target="_blank" class="btn btn-outline-secondary">Voir le PDF</a>
            @endif

            @if($cours->type_video)
                <p class="mt-3"><strong>Vidéo :</strong></p>
                <video width="400" controls>
                    <source src="{{ asset($cours->type_video) }}" type="video/mp4">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
            @endif

            <div class="mt-4">
                <a href="{{ route('cours.index') }}" class="btn btn-secondary">Retour à la liste</a>
                <a href="{{ route('cours.edit', $cours->id) }}" class="btn btn-warning">Modifier</a>
                <form action="{{ route('cours.destroy', $cours->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
