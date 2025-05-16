<!-- resources/views/formateur/show.blade.php -->

@extends('layouts.appem')

@section('content')
<div class="container">
    <h2>Mes Absences</h2><br>

    @if($absences->isEmpty())
        <div class="alert alert-info" role="alert">
            Vous n'avez pas d'absences enregistrées.
        </div>
    @else
        @foreach($absences as $absence)
            <div class="card mt-3">
                <div class="card-header">
                    <strong>Absence du {{ $absence->date_debut }} au {{ $absence->date_fin }}</strong>
                </div>
                <div class="card-body">
                    <p><strong>Raison :</strong> {{ $absence->raison }}</p>
                    <p><strong>Status :</strong> 
                        @if($absence->confirmed)
                            <span class="badge bg-success">Confirmée</span>
                        @else
                            <span class="badge bg-warning">En attente</span>
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
