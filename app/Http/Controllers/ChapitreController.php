<?php

namespace App\Http\Controllers;

use App\Models\Chapitre;
use App\Models\Category;
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
        $request->validate([
            'titre' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        Chapitre::create($request->all());

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
        $chapitre = Chapitre::findOrFail($id);

        $request->validate([
            'titre' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
        ]);

        $chapitre->update($request->all());

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
}

