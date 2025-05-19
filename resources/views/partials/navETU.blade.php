<!-- resources/views/partiels/navETU.blade.php -->

<div class="sidebar">
    <h3 class="text-center mb-4">Mon Profil</h3>
    <div class="d-flex align-items-center mb-3">
        @if(Auth::user()->image ?? false)
            <img src="{{ Storage::url(Auth::user()->image) }}" alt="Image de profil" class="profile-img" />
        @else
            <img src="{{ asset('images/default-profile.png') }}" alt="Image par défaut" class="profile-img" />
        @endif
        <strong>{{ $etudiant->name ?? 'Étudiant' }}</strong>
    </div>
    <a href="{{ route('etudiant.profile') }}"><i class="fa-regular fa-address-card me-2"></i> Voir mon profil</a>
    <a href="{{ route('etudiant.edit-profile') }}"><i class="fa-regular fa-pen-to-square me-2"></i> Modifier mon profil</a>

    <hr>

    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger">
        <i class="fa-solid fa-sign-out-alt me-2"></i> Déconnexion
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</div>

<style>
    .sidebar {
        width: 250px;
        background-color: #f8f9fa;
        padding: 20px 15px;
        border-right: 1px solid #ddd;
        height: 100vh;
        position: fixed;
    }
    .sidebar a {
        color: #333;
        text-decoration: none;
        display: block;
        padding: 10px 15px;
        border-radius: 5px;
        margin-bottom: 5px;
        transition: background-color 0.3s ease;
    }
    .sidebar a:hover {
        background-color: #e2e6ea;
    }
    .profile-img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }
</style>
