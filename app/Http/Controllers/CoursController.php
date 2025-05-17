<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Cours;
use App\Models\Category;
use App\Models\Chapitre;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function index()
    {
        $cours = Cours::with('formateur', 'categorie', 'chapitre')->get();
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
        $cours = Cours::with('formateur', 'categorie', 'chapitre')->findOrFail($id);
        return view('cours.show', compact('cours'));
    }

        public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image',
            'type_pdf' => 'nullable|file|mimes:pdf',
            'type_video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg',
            'category_id' => 'required|exists:categories,id',
            'chapitre_id' => 'required|exists:chapitres,id',
            'formateur_id' => 'required|exists:users,id',
        ]);

        $cours = new Cours();
        $cours->titre = $request->titre;
        $cours->contenu = $request->contenu;
        $cours->category_id = $request->category_id;
        $cours->chapitre_id = $request->chapitre_id;
        $cours->formateur_id = $request->formateur_id;

        // 📁 Image - enregistrée dans public/images/cours
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/cours'), $imageName);
            $cours->image = 'images/cours/' . $imageName;
        }

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
        $chapitres = Chapitre::where('category_id', $cours->category_id)->get();
        $formateurs = User::where('role', 'formateur')->get();

        return view('cours.edit', compact('cours', 'categories', 'chapitres', 'formateurs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'image' => 'nullable|image',
            'type_pdf' => 'nullable|file|mimes:pdf',
            'type_video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg',
            'category_id' => 'required|exists:categories,id',
            'chapitre_id' => 'required|exists:chapitres,id',
            'formateur_id' => 'required|exists:users,id',
        ]);

        $cours = Cours::findOrFail($id);
        $cours->titre = $request->titre;
        $cours->contenu = $request->contenu;
        $cours->category_id = $request->category_id;
        $cours->chapitre_id = $request->chapitre_id;
        $cours->formateur_id = $request->formateur_id;

        if ($request->hasFile('image')) {
            $imageName = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('images/cours'), $imageName);
            $cours->image = 'images/cours/'.$imageName;
        }

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




}
