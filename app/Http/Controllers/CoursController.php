<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cours;
use App\Models\Category;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::with('formateur', 'categorie')->get();
        return view('cours.index', compact('cours'));
    }

    public function create()
{
    $categories = Category::all();
    $formateurs = User::where('role', 'formateur')->get();
    return view('cours.create', compact('categories', 'formateurs'));
}

        public function show($id)
        {
            $cours = Cours::with('formateur', 'categorie')->findOrFail($id);
            return view('cours.show', compact('cours'));
        }

        public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'type_pdf' => 'nullable|file|mimes:pdf',
            'type_video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg',
            'category_id' => 'required|exists:categories,id',
            'formateur_id' => 'required|exists:users,id',
        ]);

        $cours = new Cours();
        $cours->titre = $request->titre;
        $cours->description  = $request->description ;
        $cours->category_id = $request->category_id;
        $cours->formateur_id = $request->formateur_id;

        // 📄 PDF
        if ($request->hasFile('type_pdf')) {
            $pdf = $request->file('type_pdf');
            $pdfName = time() . '_' . $pdf->getClientOriginalName();
            $pdf->move(public_path('pdfs'), $pdfName);
            $cours->type_pdf = 'pdfs/' . $pdfName;
        }

        // 🎞️ Vidéo
        if ($request->hasFile('type_video')) {
            $video = $request->file('type_video');
            $videoName = time() . '_' . $video->getClientOriginalName();
            $video->move(public_path('videos'), $videoName);
            $cours->type_video = 'videos/' . $videoName;
        }

        $cours->save();

        return redirect()->route('cours.index')->with('success', 'Cours ajouté avec succès.');
    }


    public function edit($id)
    {
        $cours = Cours::findOrFail($id);
        $categories = Category::all();
        $formateurs = User::where('role', 'formateur')->get();

        return view('cours.edit', compact('cours', 'categories', 'formateurs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'type_pdf' => 'nullable|file|mimes:pdf',
            'type_video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg',
            'category_id' => 'required|exists:categories,id',
            'formateur_id' => 'required|exists:users,id',
        ]);

        $cours = Cours::findOrFail($id);
        $cours->titre = $request->titre;
        $cours->description  = $request->description ;
        $cours->category_id = $request->category_id;
        $cours->formateur_id = $request->formateur_id;

        if ($request->hasFile('type_pdf')) {
            $pdfName = time().'_'.$request->file('type_pdf')->getClientOriginalName();
            $request->file('type_pdf')->move(public_path('pdfs'), $pdfName);
            $cours->type_pdf = 'pdfs/'.$pdfName;
        }

        if ($request->hasFile('type_video')) {
            $videoName = time().'_'.$request->file('type_video')->getClientOriginalName();
            $request->file('type_video')->move(public_path('videos'), $videoName);
            $cours->type_video = 'videos/'.$videoName;
        }

        $cours->save();
        return redirect()->route('cours.index')->with('success', 'Cours mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $cours = Cours::findOrFail($id);
        $cours->delete();
        return redirect()->route('cours.index')->with('success', 'Cours supprimé avec succès.');
    }

        public function getByCategory($categoryId)
    {
        $cours = Cours::where('category_id', $categoryId)->get(['id', 'titre']);
        return response()->json($cours);
    }



}
