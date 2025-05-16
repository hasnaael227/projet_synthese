@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Changer le Mot de Passe</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
    
        <div class="form-group mb-3">
            <label for="current_password">Mot de Passe Actuel</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
            <span toggle="#current_password" class="fa fa-eye toggle-password"></span>
        </div>
    
        <div class="form-group mb-3">
            <label for="new_password">Nouveau Mot de Passe</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
            <span toggle="#new_password" class="fa fa-eye toggle-password"></span>
        </div>
    
        <div class="form-group mb-3">
            <label for="new_password_confirmation">Confirmer le Nouveau Mot de Passe</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
            <span toggle="#new_password_confirmation" class="fa fa-eye toggle-password"></span>
        </div>
    
        <button type="submit" class="btn btn-primary">Changer le Mot de Passe</button>
    </form>
    
    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(item => {
            item.addEventListener('click', function() {
                const passwordField = document.querySelector(this.getAttribute('toggle'));
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</div>
@endsection
