<!-- resources/views/users/create.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un utilisateur</title>
</head>
<body>
    <h1>Formulaire pour ajouter un utilisateur</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <label>Matricule :</label>
        <input type="text" name="matricule" required><br><br>

        <label>Nom :</label>
        <input type="text" name="name" required><br><br>

        <label>Prénom :</label>
        <input type="text" name="prename" required><br><br>

        <label>Email :</label>
        <input type="email" name="email" required><br><br>

        <label>Role :</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="formateur">Formateur</option>
        </select><br><br>

        <label>Mot de passe :</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
