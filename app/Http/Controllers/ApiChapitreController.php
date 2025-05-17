<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Category;
use Illuminate\Http\Request;

class ApiChapitreController extends Controller
{
    // Liste tous les chapitres avec leur catégorie
    public function index()
    {
        $chapitres = Chapitre::with('category')->get();
        return response()->json($chapitres);
    }

    // Donne la liste des catégories (utile pour créer ou éditer)
    public function categories()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Crée un nouveau chapitre
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $chapitre = Chapitre::create($validated);

        return response()->json([
            'message' => 'Chapitre créé avec succès',
            'data' => $chapitre
        ], 201);
    }

    // Affiche un chapitre spécifique
    public function show($id)
    {
        $chapitre = Chapitre::with('category')->find($id);

        if (!$chapitre) {
            return response()->json(['message' => 'Chapitre non trouvé'], 404);
        }

        return response()->json($chapitre);
    }

    // Met à jour un chapitre
    public function update(Request $request, $id)
    {
        $chapitre = Chapitre::find($id);

        if (!$chapitre) {
            return response()->json(['message' => 'Chapitre non trouvé'], 404);
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $chapitre->update($validated);

        return response()->json([
            'message' => 'Chapitre mis à jour avec succès',
            'data' => $chapitre
        ]);
    }

    // Supprime un chapitre
    public function destroy($id)
    {
        $chapitre = Chapitre::find($id);

        if (!$chapitre) {
            return response()->json(['message' => 'Chapitre non trouvé'], 404);
        }

        $chapitre->delete();

        return response()->json(['message' => 'Chapitre supprimé avec succès']);
    }
}
