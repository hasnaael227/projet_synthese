<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />

<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded-3">
    @csrf
<h1>hhhhh</h1>
    <div class="mb-3">
        <label for="matricule" class="form-label">Matricule</label>
        <input type="text" name="matricule" class="form-control" id="matricule" required>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" name="name" class="form-control" id="name" required>
    </div>

    <div class="mb-3">
        <label for="prename" class="form-label">Prénom</label>
        <input type="text" name="prename" class="form-control" id="prename" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" id="email" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" name="password" class="form-control" id="password" required>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
        <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" class="form-control" id="image">
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Rôle</label>
        <select name="role" class="form-select" id="role" required>
            <option value="admin">Admin</option>
            <option value="formateur">Formateur</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Créer Utilisateur</button>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
