<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ApiCategoryController extends Controller
{
    // GET /api/categories
    public function index()
    {
        return response()->json(Category::all());
    }

public function store(Request $request)
{
    // Validation des champs JSON (image en base64 optionnelle en string)
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'prix' => 'nullable|numeric',
        'image' => 'nullable|string', // image base64 optionnelle
    ]);

    $filename = null;

    if (!empty($validated['image'])) {
        $imageData = $validated['image'];

        // Vérifier si la chaîne contient le préfixe "data:image/xxx;base64,"
        if (strpos($imageData, 'base64,') !== false) {
            // Extraire les données base64
            list($meta, $content) = explode('base64,', $imageData);
            $imageBinary = base64_decode($content);

            // Extraire le type d'image à partir du meta
            if (preg_match('/image\/(\w+)/', $meta, $matches)) {
                $type = strtolower($matches[1]);
                if (!in_array($type, ['jpeg', 'jpg', 'png', 'gif'])) {
                    return response()->json(['message' => 'Format d\'image non supporté.'], 422);
                }
            } else {
                return response()->json(['message' => 'Format d\'image invalide.'], 422);
            }
        } else {
            // Pas de préfixe, on suppose que c'est la base64 pure
            $imageBinary = base64_decode($imageData);
            if ($imageBinary === false) {
                return response()->json(['message' => 'Données d\'image corrompues.'], 422);
            }
            // Par défaut, extension png (ou adapte selon ton cas)
            $type = 'png';
        }

        if ($imageBinary === false) {
            return response()->json(['message' => 'Données d\'image corrompues.'], 422);
        }

        // Générer un nom unique pour le fichier
        $filename = time() . '.' . $type;

        // Enregistrer le fichier dans public/images/categories
        file_put_contents(public_path('images/categories/') . $filename, $imageBinary);
    }

    // Créer la catégorie avec les données validées + nom image si présent
    $category = new Category();
    $category->name = $validated['name'];
    $category->description = $validated['description'] ?? null;
    $category->prix = $validated['prix'] ?? null;
    $category->image = $filename; // null si pas d'image
    $category->save();

    // Réponse JSON avec succès
    return response()->json([
        'message' => 'Catégorie créée avec succès.',
        'category' => $category
    ], 201);
}


    // GET /api/categories/{id}
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Catégorie non trouvée.'], 404);
        }

        return response()->json($category);
    }

    // PUT/PATCH /api/categories/{id}
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Catégorie non trouvée.'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $validated['image'] = $request->file('image')->store('images/categories', 'public');
        }

        $category->update($validated);

        return response()->json([
            'message' => 'Catégorie mise à jour avec succès.',
            'category' => $category,
        ]);
    }

    // DELETE /api/categories/{id}
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Catégorie non trouvée.'], 404);
        }

        if ($category->image && Storage::disk('public')->exists($category->image)) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return response()->json([
            'message' => 'Catégorie supprimée avec succès.'
        ]);
    }
}
