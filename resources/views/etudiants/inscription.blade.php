@extends('layouts.appETU')

@section('content')
<h1>Connexion Étudiant</h1>

@if ($errors->any())
    <div style="color: red;">
        {{ $errors->first() }}
    </div>
@endif

<form action="{{ route('login.submit') }}" method="POST">
    @csrf
    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Mot de passe"><br>
    <button type="submit">Se connecter</button>
</form>
@endsection