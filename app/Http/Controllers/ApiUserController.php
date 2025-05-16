<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class ApiUserController extends Controller
{
    // Lister tous les utilisateurs
    public function index()
    {
        return response()->json(User::all());
    }

    // Créer un nouvel utilisateur
    public function store(Request $request)
    {
        $request->validate([
            'matricule' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'prename' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,formateur',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('users', 'public') : null;

        $user = User::create([
            'matricule' => $request->matricule,
            'name' => $request->name,
            'prename' => $request->prename,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'image' => $imagePath,
        ]);

        return response()->json($user, 201);
    }

    // Afficher un utilisateur
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        return response()->json($user);
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['error' => 'Utilisateur non trouvé'], 404);

        $request->validate([
            'name' => 'required|string|max:255',
            'prename' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,formateur',
            'password' => 'nullable|string|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        $user->prename = $request->prename;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('image')) {
            $user->image = $request->file('image')->store('users', 'public');
        }

        $user->save();

        return response()->json($user);
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['error' => 'Utilisateur non trouvé'], 404);

        $user->delete();
        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }

// ==== PROFIL ====

public function profile($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        // Exemple : tu peux filtrer les données retournées selon le rôle
        if ($user->role === 'admin' || $user->role === 'formateur') {
            return response()->json($user);
        }

        return response()->json(['error' => 'Accès refusé'], 403);
    }

        public function updateProfile(Request $request, $id)
        {
            // Trouver l'utilisateur par id
            $user = User::find($id);
            
            if (!$user) {
                return response()->json(['error' => 'Utilisateur non trouvé'], 404);
            }

            // Mettre à jour les champs (name, prename, email) uniquement si envoyés dans la requête
            $user->name = $request->input('name', $user->name);
            $user->prename = $request->input('prename', $user->prename);
            $user->email = $request->input('email', $user->email);

            $user->save();

            return response()->json([
                'message' => 'Profil mis à jour avec succès',
                'user' => $user
            ]);
        }



    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non trouvé'], 404);
        }

        // Vérifier mot de passe actuel (hashé)
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['error' => 'Mot de passe actuel incorrect'], 401);
        }

        // Hashage du nouveau mot de passe
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Mot de passe mis à jour avec succès']);
    }



    public function login(Request $request)
{
    // Validation simple
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Trouver utilisateur par email
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['error' => 'Utilisateur non trouvé'], 404);
    }

    // Vérifier le mot de passe (hashé)
    if (!Hash::check($request->password, $user->password)) {
    return response()->json(['error' => 'Mot de passe incorrect'], 401);
}

    // Si ok, renvoyer user + rôle
    return response()->json([
        'message' => 'Connexion réussie',
        'user' => $user,
    ]);
}
    // ✅ Déconnexion API - à l'intérieur de la classe
    public function logout(Request $request)
    {
        // Sans authentification, on simule juste la déconnexion
        return response()->json(['message' => 'Déconnexion réussie']);
    }
}

