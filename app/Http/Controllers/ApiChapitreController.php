<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chapitre;
use App\Models\Category;
use App\Models\Cours;
use Illuminate\Http\Request;

class ApiChapitreController extends Controller
{
    public function index()
    {
        $chapitres = Chapitre::with('category')->get();
        return response()->json($chapitres);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'cours_id' => 'required|exists:cours,id',
        ]);

        $chapitre = Chapitre::create($validated);

        return response()->json(['message' => 'Chapitre créé avec succès', 'chapitre' => $chapitre], 201);
    }

    public function show($id)
    {
        $chapitre = Chapitre::with('category', 'cours')->findOrFail($id);
        return response()->json($chapitre);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'cours_id' => 'required|exists:cours,id',
        ]);

        $chapitre = Chapitre::findOrFail($id);
        $chapitre->update($validated);

        return response()->json(['message' => 'Chapitre mis à jour avec succès', 'chapitre' => $chapitre]);
    }

    public function destroy($id)
    {
        $chapitre = Chapitre::findOrFail($id);
        $chapitre->delete();

        return response()->json(['message' => 'Chapitre supprimé avec succès']);
    }

    public function getByCategorie($id)
    {
        $chapitres = Chapitre::where('category_id', $id)->get(['id', 'titre']);
        return response()->json($chapitres);
    }

    public function addCourse(Request $request, $chapitreId)
    {
        $chapitre = Chapitre::find($chapitreId);

        if (!$chapitre) {
            return response()->json(['error' => 'Chapitre introuvable'], 404);
        }

        return response()->json(['message' => 'Chapitre trouvé', 'chapitre' => $chapitre]);
    }

    public function removeCourse($chapitreId, $coursId)
    {
        $chapitre = Chapitre::findOrFail($chapitreId);
        $chapitre->cours()->detach($coursId);

        return response()->json(['message' => 'Cours supprimé du chapitre avec succès.']);
    }
}
