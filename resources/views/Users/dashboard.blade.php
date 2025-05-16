@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Tableau de Bord - Admin</h2>
    <div class="row">

        <!-- Carte Admin -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-left-primary">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-user-shield fa-3x text-primary"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">Administrateurs</h5>
                        <h2 class="fw-bold">{{ $adminCount }}</h2>
                        <p class="text-muted mb-0">Nombre total des comptes admin dans le système.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Formateur -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-left-success">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-chalkboard-teacher fa-3x text-success"></i>
                    </div>
                    <div>
                        <h5 class="card-title mb-1">Formateurs</h5>
                        <h2 class="fw-bold">{{ $formateurCount }}</h2>
                        <p class="text-muted mb-0">Formateurs actifs enregistrés dans la plateforme.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
