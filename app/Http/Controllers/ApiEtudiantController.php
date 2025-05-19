<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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

        public function update(Request $request, Etudiant $etudiant)
    {
        // Validation des champs
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'numTel' => 'required|string|max:20',
            'email' => 'required|email|unique:etudiants,email,' . $etudiant->id,
            'password' => 'nullable|string|min:6',
        ]);

        // Mise à jour des champs
        $etudiant->nom = $validated['nom'];
        $etudiant->prenom = $validated['prenom'];
        $etudiant->numTel = $validated['numTel'];
        $etudiant->email = $validated['email'];

        if (!empty($validated['password'])) {
            $etudiant->password = Hash::make($validated['password']);
        }

        $etudiant->save();

        // Réponse JSON
        return response()->json([
            'message' => 'Étudiant mis à jour avec succès.',
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
            // Générer un token
            $token = Str::random(60);
            $etudiant->api_token = $token;
            $etudiant->save();

            return response()->json([
                'message' => 'Connexion réussie',
                'etudiant' => $etudiant,
                'token' => $token,
            ]);
        }

        return response()->json(['message' => 'Email ou mot de passe incorrect'], 401);
    }

public function logout(Request $request)
{
    $token = $request->bearerToken();

    $etudiant = Etudiant::where('api_token', $token)->first();

    if (!$etudiant) {
        return response()->json(['message' => 'Token invalide'], 401);
    }

    $etudiant->api_token = null;
    $etudiant->save();

    return response()->json(['message' => 'Déconnexion réussie']);
}


public function profile(Request $request)
{
    $token = $request->bearerToken(); // ou $request->header('Authorization')

    $etudiant = Etudiant::where('api_token', $token)->first();

    if (!$etudiant) {
        return response()->json(['message' => 'Token invalide.'], 401);
    }

    return response()->json([
        'message' => 'Profil récupéré avec succès.',
        'etudiant' => $etudiant,
    ]);
}

public function editProfile()
{
    $etudiant = Auth::guard('sanctum')->user();

    if (!$etudiant) {
        return response()->json(['message' => 'Non autorisé.'], 401);
    }

    return response()->json([
        'message' => 'Données de l\'étudiant à modifier.',
        'etudiant' => $etudiant,
    ]);
}
}
