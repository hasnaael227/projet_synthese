@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le Profil</h1><br>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

            <!-- Matricule -->
            <div class="row mb-3">
                <label for="matricule" class="col-md-4 col-form-label text-md-end">{{ __('Matricule') }}</label>
                <div class="col-md-6">
                    <input id="matricule" type="text" class="form-control @error('matricule') is-invalid @enderror" name="matricule" value="{{ old('matricule', $user->matricule) }}" required>
                    @error('matricule')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

        <!-- Nom -->
        <div class="row mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nom') }}</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <!-- Prénom -->
        <div class="row mb-3">
            <label for="prename" class="col-md-4 col-form-label text-md-end">{{ __('Prénom') }}</label>
            <div class="col-md-6">
                <input id="prename" type="text" class="form-control @error('prename') is-invalid @enderror" name="prename" value="{{ old('prename', $user->prename) }}" required>
                @error('prename')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <!-- Email -->
        <div class="row mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <!-- Image -->
        <div class="row mb-3">
            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Image de Profil') }}</label>
            <div class="col-md-6">
                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                @if ($user->image)
                    <img src="{{ asset('storage/' . $user->image) }}" alt="Image de Profil" class="img-thumbnail mt-2" style="max-width: 100px;">
                @endif
                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <!-- Bouton de mise à jour -->
        <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>

                <a href="{{ route('users.profile') }}" class="btn btn-secondary">
                    {{ __('Retour au profil') }}
                </a>
                
            </div>
        </div>
    </form>
</div>
@endsection
