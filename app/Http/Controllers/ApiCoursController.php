<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApiCoursController extends Controller
{
        public function index()
    {
        $cours = Cours::with('formateur', 'categorie')->get();
        return response()->json($cours);
    }

    public function show($id)
    {
        $cours = Cours::with('formateur', 'categorie')->find($id);
        if (!$cours) {
            return response()->json(['message' => 'Cours non trouvé'], 404);
        }
        return response()->json($cours);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'type_pdf' => 'nullable|file|mimes:pdf',
            'type_video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg',
            'category_id' => 'required|exists:categories,id',
            'formateur_id' => 'required|exists:users,id',
        ]);

        $cours = new Cours($validated);


        if ($request->hasFile('type_pdf')) {
            $cours->type_pdf = $request->file('type_pdf')->store('pdfs', 'public');
        }

        if ($request->hasFile('type_video')) {
            $cours->type_video = $request->file('type_video')->store('videos', 'public');
        }

        $cours->save();

        return response()->json($cours, 201);
    }

    public function update(Request $request, $id)
    {
        $cours = Cours::find($id);
        if (!$cours) {
            return response()->json(['message' => 'Cours non trouvé'], 404);
        }

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'type_pdf' => 'nullable|file|mimes:pdf',
            'type_video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg',
            'category_id' => 'required|exists:categories,id',
            'formateur_id' => 'required|exists:users,id',
        ]);

        $cours->update($validated);

        if ($request->hasFile('type_pdf')) {
            $cours->type_pdf = $request->file('type_pdf')->store('pdfs', 'public');
        }

        if ($request->hasFile('type_video')) {
            $cours->type_video = $request->file('type_video')->store('videos', 'public');
        }

        $cours->save();

        return response()->json($cours);
    }

    public function destroy($id)
    {
        $cours = Cours::find($id);
        if (!$cours) {
            return response()->json(['message' => 'Cours non trouvé'], 404);
        }

        $cours->delete();
        return response()->json(['message' => 'Cours supprimé avec succès']);
    }
        public function getByCategory($categoryId)
    {
        $cours = Cours::where('category_id', $categoryId)->get(['id', 'titre']);
        return response()->json($cours);
    }
}
