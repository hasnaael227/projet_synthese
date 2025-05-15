<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Projet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ApiUsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['login', 'store']); // Allow 'login' and 'store' to be accessed without authentication
    }

    // Afficher la liste des utilisateurs (Admin uniquement)
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    // Enregistrer un nouvel utilisateur dans la base de données
    public function store(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'prename' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'required|in:admin,employee',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('users', 'public');
        }

        $user = User::create([
            'matricule' => $validated['matricule'],
            'name' => $validated['name'],
            'prename' => $validated['prename'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'image' => $imagePath,
            'role' => $validated['role'],
        ]);

        return response()->json($user, 201);
    }

    // Afficher les détails d'un utilisateur
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Accès refusé.'], 403);
        }

        $validated = $request->validate([
            'matricule' => 'required|string|max:255|unique:users,matricule,' . $id,
            'name' => 'required|string|max:255',
            'prename' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'required|in:admin,employee',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $request->file('image')->store('users', 'public');
        }

        $user->update($request->only('matricule', 'name', 'prename', 'email', 'role'));

        return response()->json(['message' => 'Utilisateur mis à jour avec succès', 'user' => $user]);
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Accès refusé.'], 403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé avec succès']);
    }

    // Authentification de l'utilisateur
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'message' => 'Connexion réussie',
                'token' => $token,
                'user' => $user,
            ]);
        }

        return response()->json(['error' => 'Identifiants invalides'], 401);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion réussie']);
    }

    // Profile
    public function profile()
    {
        $user = User::find(auth()->id()); // Get the authenticated user

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404); // Return error if no user is found
        }

        if ($user->role === 'admin') {
            return response()->json(['user' => $user], 200); // Admin profile data as JSON
        } elseif ($user->role === 'employee') {
            return response()->json(['user' => $user], 200); // Employee profile data as JSON
        } else {
            return response()->json(['message' => 'Unauthorized action.'], 403); // If the role doesn't match any condition
        }
    }

    // Dashboard pour Admin
    public function dashboard()
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Accès non autorisé.'], 403);
        }

        $projetCount = Projet::count();
        $userCount = User::count();
        return response()->json([
            'projetCount' => $projetCount,
            'userCount' => $userCount,
        ]);
    }

    // Method to handle password change without authentication
    public function changePassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        // Find the user by user_id
        $user = User::find($request->input('user_id'));

        // Check if the current password matches
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return response()->json(['error' => 'Current password is incorrect.'], 400);
        }

        // Update the password
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return response()->json(['message' => 'Password changed successfully.'], 200);
    }

        public function viewProjects()
    {
        // Get all projects regardless of the user's role
        $projets = Projet::all();

        return response()->json(['projects' => $projets]);
    }

        public function editProfile()
    {
        // Just return a default profile data or some placeholder, as no authentication is being checked
        $user = [
            'name' => 'Default User',
            'prename' => 'Default',
            // You can add other fields as needed
        ];

        return response()->json(['user' => $user]);
    }

        public function updateProfile(Request $request)
    {
        
        $user = new \stdClass();  // Just an example, you might use actual data for the user object

        $user->name = $request->input('name');
        $user->prename = $request->input('prename');
        // Update other fields as needed

        return response()->json([
            'message' => 'Profile updated successfully.',
            'user' => $user
        ]);
    }

}
