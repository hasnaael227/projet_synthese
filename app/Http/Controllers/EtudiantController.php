<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
    public function index()
    {
        $etudiants = Etudiant::all();
        return view('etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        return view('etudiants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'numTel' => 'required',
            'email' => 'required|email|unique:etudiants',
            'password' => 'required|min:6',
        ]);

        Etudiant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'numTel' => $request->numTel,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('etudiants.index');
    }

    public function show(Etudiant $etudiant)
    {
        return view('etudiants.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        return view('etudiants.edit', compact('etudiant'));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'numTel' => 'required',
            'email' => 'required|email|unique:etudiants,email,' . $etudiant->id,
        ]);

        $etudiant->update($request->only(['nom', 'prenom', 'numTel', 'email']));

        return redirect()->route('etudiants.index');
    }

    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        return redirect()->route('etudiants.index');
    }

    // Afficher le formulaire de login (nommé inscription)
    public function showLoginForm()
    {
        return view('etudiants.inscription'); // la vue s'appelle inscription.blade.php
    }

    // Traitement du login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $etudiant = Etudiant::where('email', $request->email)->first();

        if ($etudiant && Hash::check($request->password, $etudiant->password)) {
            session(['etudiant' => $etudiant]);
            return redirect()->route('etudiants.index');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect']);
    }

    // Déconnexion
    public function logout()
    {
        session()->forget('etudiant');
        return redirect()->route('login.form');
    }

        public function profile()
    {
        $etudiant = session('etudiant');

        if (!$etudiant) {
            return redirect()->route('login.form');
        }

        return view('etudiants.profile', compact('etudiant'));
    }

        public function editProfile()
    {
        $etudiant = session('etudiant');

        if (!$etudiant) {
            return redirect()->route('login.form');
        }

        return view('etudiants.edit-profile', compact('etudiant'));
    }

}

