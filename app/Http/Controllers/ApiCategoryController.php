<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ApiCategoryController extends Controller
{
    // Afficher toutes les catégories (GET /api/categories)
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    // Enregistrer une nouvelle catégorie (POST /api/categories)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Catégorie créée avec succès.',
            'category' => $category,
        ], 201);
    }

    // Afficher les détails d'une catégorie (GET /api/categories/{id})
    public function show(Category $category)
    {
        return response()->json($category);
    }

    // Mettre à jour une catégorie (PUT/PATCH /api/categories/{id})
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Catégorie mise à jour avec succès.',
            'category' => $category,
        ]);
    }

    // Supprimer une catégorie (DELETE /api/categories/{id})
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès.'
        ]);
    }
}
