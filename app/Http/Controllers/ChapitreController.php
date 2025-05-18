<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Category;
use App\Models\Chapitre;
use Illuminate\Http\Request;

class ChapitreController extends Controller
{
    public function index()
    {
        $chapitres = Chapitre::with('category')->get();
        return view('chapitres.index', compact('chapitres'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('chapitres.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validation avec cours_id ajouté
        $request->validate([
            'titre' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'cours_id' => 'required|exists:cours,id',
        ]);

        // Création du chapitre avec tous les champs nécessaires
        Chapitre::create([
            'titre' => $request->titre,
            'category_id' => $request->category_id,
            'cours_id' => $request->cours_id,  // <-- Cette colonne n’existe pas, ne mets pas ça ici !
        ]);


        return redirect()->route('chapitres.index')->with('success', 'Chapitre créé avec succès');
    }

    public function show($id)
    {
        $chapitre = Chapitre::findOrFail($id);
        return view('chapitres.show', compact('chapitre'));
    }

        public function edit($id)
    {
        $chapitre = Chapitre::findOrFail($id);
        $categories = Category::all();
        return view('chapitres.edit', compact('chapitre', 'categories'));
    }

public function update(Request $request, $id)
{
    // Validate the incoming request data
    $request->validate([
        'titre' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'cours_id' => 'required|exists:cours,id',
    ]);

    // Find the chapitre by its ID
    $chapitre = Chapitre::findOrFail($id);

    // Update the chapitre fields
    $chapitre->update([
        'titre' => $request->titre,
        'category_id' => $request->category_id,
        'cours_id' => $request->cours_id,
    ]);

    // Redirect back to the list or details page with success message
    return redirect()->route('chapitres.index')->with('success', 'Chapitre mis à jour avec succès');
}

    public function destroy($id)
    {
        $chapitre = Chapitre::findOrFail($id);
        $chapitre->delete();
        return redirect()->route('chapitres.index')->with('success', 'Chapitre supprimé');
    }
        public function getByCategorie($id)
    {
        $chapitres = Chapitre::where('category_id', $id)->get(['id', 'titre']);
        return response()->json($chapitres);
    }


public function addCourseForm($chapitreId)
{
    $chapitre = Chapitre::with('cours', 'category')->findOrFail($chapitreId);

    $coursIdsDejaDansChapitre = $chapitre->cours->pluck('id')->toArray();

    // Récupérer les cours de la même catégorie que le chapitre, qui ne sont pas déjà associés
    $coursDisponibles = Cours::with('category')
        ->where('category_id', $chapitre->category_id)
        ->whereNotIn('id', $coursIdsDejaDansChapitre)
        ->get();

    return view('chapitres.add_cours', [
        'chapitre' => $chapitre,
        'availableCourses' => $coursDisponibles,
        'existingCours' => $chapitre->cours,
    ]);
}

public function addCourse(Request $request, $chapitreId)
    {
        $request->validate([
            'cours_id' => 'required|exists:cours,id',
        ]);

        $chapitre = Chapitre::findOrFail($chapitreId);

        // Attach the course if not already linked
        if (!$chapitre->cours()->where('cours_id', $request->cours_id)->exists()) {
            $chapitre->cours()->attach($request->cours_id);
        }

        return redirect()->back()->with('success', 'Cours ajouté au chapitre avec succès.');
    }

        public function removeCourse($chapitreId, $coursId)
    {
        $chapitre = Chapitre::findOrFail($chapitreId);

        // Supposons que ta relation s’appelle 'cours' dans le modèle Chapitre
        $chapitre->cours()->detach($coursId);

        return redirect()->back()->with('success', 'Cours supprimé du chapitre avec succès.');
    }

}

