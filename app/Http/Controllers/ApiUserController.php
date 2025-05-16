<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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

    // Ici, on doit recevoir l'id du profil à afficher
    public function profile($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
        }
        return response()->json(['user' => $user], 200);
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
            $user->image = $imagePath;
        }

        $user->save();

        return response()->json(['message' => 'Profil mis à jour.', 'user' => $user], 200);
    }

  public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'Mot de passe modifié avec succès.'], 200);
    }

    // ✅ Déconnexion API - à l'intérieur de la classe
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie']);
    }
}

