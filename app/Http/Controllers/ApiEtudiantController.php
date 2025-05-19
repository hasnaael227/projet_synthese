<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiEtudiantController extends Controller
{
    public function index()
    {
        $etudiants = Etudiant::all();
        return response()->json($etudiants);
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

        $etudiant = Etudiant::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'numTel' => $request->numTel,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'Etudiant créé avec succès',
            'etudiant' => $etudiant
        ], 201);
    }

    public function show($id)
    {
        $etudiant = Etudiant::find($id);

        if (!$etudiant) {
            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }

        return response()->json($etudiant);
    }

    public function update(Request $request, $id)
    {
        $etudiant = Etudiant::find($id);

        if (!$etudiant) {
            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }

        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'numTel' => 'required',
            'email' => 'required|email|unique:etudiants,email,' . $id,
        ]);

        $etudiant->update($request->only(['nom', 'prenom', 'numTel', 'email']));

        return response()->json([
            'message' => 'Étudiant mis à jour avec succès',
            'etudiant' => $etudiant
        ]);
    }

    public function destroy($id)
    {
        $etudiant = Etudiant::find($id);

        if (!$etudiant) {
            return response()->json(['message' => 'Étudiant non trouvé'], 404);
        }

        $etudiant->delete();

        return response()->json(['message' => 'Étudiant supprimé avec succès']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $etudiant = Etudiant::where('email', $request->email)->first();

        if ($etudiant && Hash::check($request->password, $etudiant->password)) {
            return response()->json([
                'message' => 'Connexion réussie',
                'etudiant' => $etudiant
            ]);
        }

        return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
    }

    public function logout()
    {
        // Pour les APIs RESTful, la gestion de session se fait souvent par token.
        // Ici on simule un logout.
        return response()->json(['message' => 'Déconnexion réussie']);
    }
}
