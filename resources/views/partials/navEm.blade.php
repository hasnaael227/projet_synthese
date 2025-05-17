<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 10px 15px;
            display: block;
            color: #333;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #e2e6ea;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="sidebar">
    <h3 class="text-center">Mon Profil</h3>
    <ul class="list-unstyled">
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" aria-expanded="false" aria-controls="submenuUsers">
                <i class="fa-solid fa-user-tie"></i>
                @if(session('formateur_image'))
                    <img src="{{ Storage::url(session('formateur_image')) }}" class="img-thumbnail" width="30" height="30" alt="Image de profil" style="border-radius: 50%; margin-right: 10px;">
                @else
                    <img src="url_par_defaut.jpg" class="img-thumbnail" width="30" height="30" alt="Image par défaut" style="border-radius: 50%; margin-right: 10px;">
                @endif
                @if(session('formateur_name'))
                    <span>{{ session('formateur_name') }}</span>
                @else
                <span class="text-success"> {{ Auth::check() ? Auth::user()->name : 'Invité' }} </span>                @endif
            </a>
        </li>
        <li><a href="{{ route('formateurs.profile') }}"> <i class="fa-regular fa-address-card"></i> Mon Profil</a></li>
        <li><a href="{{ route('formateurs.edit') }}"> <i class="fa-regular fa-pen-to-square"></i> Modifier</a></li>
                <li><a href="{{ route('categories.index') }}"> <i class="fa-regular fa-pen-to-square"></i> liste des categories</a></li>
        <li><a href="{{ route('categories.create') }}"> <i class="fa-regular fa-pen-to-square"></i> ajouter les categories</a></li>

        <li><a href="{{ route('formateurs.change_password') }}"> <i class="fa-solid fa-lock"></i> Changer le Mot de Passe</a></li>
        <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ route('users.logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-sign-out-alt"></i> Déconnexion
                    </a>
                </li>
                <form id="logout-form" action="{{ route('users.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
    </ul>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
