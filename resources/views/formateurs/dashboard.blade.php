@extends('layouts.appem')

@section('content')
    <h1>Bienvenue au tableau de bord Formateur, <span style="color: green">{{ $user->name }}</span>!</h1>
    <p>Ceci est votre espace personnel pour gérer vos cours et profils.</p>
@endsection
