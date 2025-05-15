<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Afficher la liste des utilisateurs (Admin uniquement)
    public function index()
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            return redirect()->route('users.dashboard')->with('error', 'Accès refusé.');
        }

        $users = User::all();
        return view('users.index', compact('users'));
    }


public function create()
{
    return view('users.create');  // Le nom de la vue doit correspondre à un fichier Blade dans resources/views/users/create.blade.php
}


    // Afficher le formulaire pour créer un nouvel utilisateur
    public function register()
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            return redirect()->route('users.dashboard')->with('error', 'Accès refusé.');
        }

        return view('users.register');
    }

    // Enregistrer un nouvel utilisateur dans la base de données
    public function store(Request $request)
{
    // Validation simple
    $validated = $request->validate([
        'matricule' => 'required|unique:users,matricule',
        'name' => 'required',
        'prename' => 'required',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|in:admin,formateur',
        'password' => 'required|min:6',
    ]);

    // Création utilisateur
    \App\Models\User::create([
        'matricule' => $validated['matricule'],
        'name' => $validated['name'],
        'prename' => $validated['prename'],
        'email' => $validated['email'],
        'role' => $validated['role'],
        'password' => bcrypt($validated['password']),
    ]);

    return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès');
}

    // Afficher les détails d'un utilisateur
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    // Afficher le formulaire de modification d'un utilisateur
    public function edit($id)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            return redirect()->route('users.dashboard')->with('error', 'Accès refusé.');
        }

        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            return redirect()->route('users.dashboard')->with('error', 'Accès refusé.');
        }

        $validated = $request->validate([
            'matricule' => 'required|string|max:255|unique:users,matricule,' . $id,
            'name' => 'required|string|max:255',
            'prename' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role' => 'required|in:admin,formateur',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $user->image = $request->file('image')->store('users', 'public');
        }

        $user->update($request->only('matricule', 'name', 'prename', 'email', 'role'));

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès');
    }

    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            if ($user->role == 'admin') {
                return redirect()->route('users.dashboard');
            } elseif ($user->role == 'formateur') {
                return redirect()->route('formateurs.profile');
            }
        }

        return redirect()->route('login')->withErrors(['email' => 'Invalid credentials']);
    }

    // Display the admin dashboard
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            return redirect()->route('users.dashboard')->withErrors(['role' => 'Accès non autorisé.']);
        }

        $adminCount = User::where('role', 'admin')->count();
        $formateurCount = User::where('role', 'formateur')->count();

        return view('users.dashboard', compact('adminCount', 'formateurCount', 'user'));
    }

    // Déconnexion
        public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login'); // Ou la route de connexion
    }

    

    // Supprimer un utilisateur
    public function destroy($id)
    {
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            return redirect()->route('users.dashboard')->with('error', 'Accès refusé.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès');
    }

    public function changePasswordForm()
    {
        return view('formateurs.change_password'); // Vue changement mdp formateur
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('formateurs.profile')->with('success', 'Password changed successfully.');
    }

    public function profile()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('users.profile', compact('user'));
        } elseif ($user->role === 'formateur') {
            return view('formateurs.profile', compact('user'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function editProfile()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return view('users.editProfile', compact('user'));
        } elseif ($user->role === 'formateur') {
            return view('formateurs.edit', compact('user'));
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $user->name = $request->input('name');
        $user->prename = $request->input('prename');
        // ajouter d'autres champs à modifier si besoin

        $user->save();

        if ($user->role === 'admin') {
            return redirect()->route('users.profile')->with('success', 'Profil mis à jour avec succès.');
        } elseif ($user->role === 'formateur') {
            return redirect()->route('formateurs.profile')->with('success', 'Profil mis à jour avec succès.');
        }
    }
}
