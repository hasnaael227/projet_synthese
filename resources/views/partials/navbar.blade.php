<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Employés - Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            padding-top: 20px;
        }
        .sidebar a {
            padding: 12px 15px;
            display: flex;
            align-items: center;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background-color: #e9ecef;
        }
        .sidebar i {
            margin-right: 10px;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
        }
        .navbar-brand {
            font-size: 18px;
            font-weight: bold;
            padding: 15px;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <a class="navbar-brand" href="#">Gestion des Employés</a>
        <ul class="nav flex-column">
            @guest('users')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">
                        <i class="fa-solid fa-sign-in-alt"></i> Connexion Utilisateur
                    </a>
                </li>
            @endguest

            
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" aria-expanded="false" aria-controls="submenuUsers">
                        <i class="fa-solid fa-user-tie"></i>
                        {{-- @if(Auth::check())
                            <img src="{{ Storage::url(Auth::user()->image) }}" class="img-thumbnail" width="30" height="30" alt="Image de profil" style="border-radius: 50%; margin-right: 10px;">
                        @else
                            <img src="url_par_defaut.jpg" class="img-thumbnail" width="30" height="30" alt="Image par défaut" style="border-radius: 50%; margin-right: 10px;">
                        @endif --}}
                        <span>{{ Auth::check() ? Auth::user()->name : 'Invité' }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.dashboard') ? 'active' : '' }}" href="{{ route('users.dashboard') }}">
                        <i class="fa-solid fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#submenuUsers" role="button" aria-expanded="false" aria-controls="submenuUsers">
                        <i class="fa-solid fa-users"></i> Utilisateurs
                        <i class="fa-solid fa-chevron-down"></i>
                    </a>
                    <div class="collapse" id="submenuUsers">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">
                                    <i class="fa-solid fa-list"></i> Tous les Utilisateurs
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.create') }}" class="nav-link">
                                    <i class="fa-solid fa-user-plus"></i> Ajouter utilisateur
                                </a>

                            </li>
                        </ul>
                    </div>
                </li>

                <li><a href="{{ route('categories.index') }}"> <i class="fa-regular fa-pen-to-square"></i> liste des categories</a></li>
        <li><a href="{{ route('categories.create') }}"> <i class="fa-regular fa-pen-to-square"></i> ajouter les categories</a></li>


                        <li><a href="{{ route('chapitres.index') }}"> <i class="fa-regular fa-pen-to-square"></i> liste des chapitres</a></li>
        <li><a href="{{ route('chapitres.create') }}"> <i class="fa-regular fa-pen-to-square"></i> ajouter les chapitres</a></li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.profile') ? 'active' : '' }}" href="{{ route('users.profile') }}">
                        <i class="fa-solid fa-tachometer-alt"></i> Profile
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ route('users.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-sign-out-alt"></i> Déconnexion
                    </a>
                
                    <!-- Logout Form -->
                    <form id="logout-form" action="{{ route('users.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                </li>
        </ul>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
