<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Etudiant;
use App\Models\Paiement;
use Illuminate\Http\Request;

class ApiPaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with('category', 'etudiant')->latest()->get();
        return response()->json($paiements, 200);
    }

    public function show($id)
    {
        $paiement = Paiement::with('category', 'etudiant')->find($id);
        if (!$paiement) {
            return response()->json(['error' => 'Paiement non trouvé'], 404);
        }
        return response()->json($paiement, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'category_id' => 'required|exists:categories,id',
            'cin' => 'required|string|max:20',
            'numero_carte' => 'required|string|max:20',
            'date_expiration' => 'required|date_format:Y-m',
            'code_securite' => 'required|string|max:5',
        ]);

        // Vérifier si paiement déjà fait pour cet étudiant et cette catégorie
        $etudiant = Etudiant::find($validated['etudiant_id']);
        if ($etudiant->categories()->where('category_id', $validated['category_id'])->exists()) {
            return response()->json(['error' => 'Catégorie déjà payée par cet étudiant'], 400);
        }

        $paiement = Paiement::create($validated);

        // Attacher la catégorie à l'étudiant
        $etudiant->categories()->attach($validated['category_id']);

        return response()->json([
            'message' => 'Paiement enregistré avec succès',
            'paiement' => $paiement,
        ], 201);
    }

    public function destroy($id)
    {
        $paiement = Paiement::find($id);
        if (!$paiement) {
            return response()->json(['error' => 'Paiement non trouvé'], 404);
        }

        $paiement->delete();
        return response()->json(['message' => 'Paiement supprimé'], 200);
    }
}
