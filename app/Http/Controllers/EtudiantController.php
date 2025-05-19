<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

        public function update(Request $request, Etudiant $etudiant = null)
    {
        // Si aucun étudiant passé en paramètre, on récupère l'étudiant connecté (profil)
        if (!$etudiant) {
            $etudiant = Etudiant::find(session('etudiant')->id);
            if (!$etudiant) {
                return redirect()->route('login.form');
            }
        }

        // Validation
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'numTel' => 'required',
            'email' => 'required|email|unique:etudiants,email,' . $etudiant->id,
            'password' => 'nullable|min:6',
        ]);

        // Mise à jour des champs
        $etudiant->nom = $request->nom;
        $etudiant->prenom = $request->prenom;
        $etudiant->numTel = $request->numTel;
        $etudiant->email = $request->email;

        if ($request->filled('password')) {
            $etudiant->password = Hash::make($request->password);
        }

        $etudiant->save();

        // Si mise à jour du profil connecté, mettre à jour la session
        if (session('etudiant') && session('etudiant')->id == $etudiant->id) {
            session(['etudiant' => $etudiant]);
            return redirect()->route('etudiant.profile')->with('success', 'Profil mis à jour avec succès.');
        }

        // Sinon (ex: admin modifie un étudiant), rediriger vers liste étudiants
        return redirect()->route('etudiants.index')->with('success', 'Étudiant mis à jour avec succès.');
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
        return redirect()->route('etudiant.profile');
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


    public function afficherProgression($etudiantId)
{
    $etudiant = Etudiant::find($etudiantId);

    if (!$etudiant) {
        abort(404, 'Étudiant non trouvé');
    }
    
    $categories = Category::with('cours')->get();

    $coursTermines = $etudiant->progressions()->where('completed', true)->pluck('cours_id')->toArray();

    $resultats = [];

    foreach ($categories as $categorie) {
        $coursIds = $categorie->cours->pluck('id')->toArray();
        $total = count($coursIds);
        $done = count(array_intersect($coursIds, $coursTermines));

        $resultats[] = [
            'categorie' => $categorie->name,
            'progression' => $total > 0 ? round(($done / $total) * 100) : 0
        ];
    }

    return view('etudiants.progression', compact('resultats'));
}

}

