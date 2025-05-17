<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Afficher toutes les catégories
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Afficher le formulaire de création
    public function create()
    {
        return view('categories.create');
    }

    // Enregistrer une nouvelle catégorie
    public function store(Request $request)
{
    // Validate form inputs (adjust rules as needed)
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'prix' => 'nullable|numeric',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
    ]);

    $filename = null;

    // Check if an image was uploaded
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        // Create a unique filename with timestamp + original name
        $filename = time() . '_' . $file->getClientOriginalName();
        // Move file to public/images folder
        $file->move(public_path('images/categories'), $filename);
    }

    // Create new category record
    $category = new Category();
    $category->name = $request->input('name');
    $category->description = $request->input('description');
    $category->prix = $request->input('prix');
    $category->image = $filename; // save filename or null if no file uploaded
    $category->save();

    // Redirect back with success message
    return redirect()->route('categories.index')->with('success', 'Category created successfully!');
}

    // Afficher les détails d'une catégorie
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    // Afficher le formulaire d'édition
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Mettre à jour la catégorie
        public function update(Request $request, Category $category)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'prix' => 'nullable|numeric',
            ]);

            $data = $request->all();

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/categories'), $imageName);
                $data['image'] = 'images/categories/' . $imageName;
            }

            $category->update($data);

            return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès.');
        }

    // Supprimer une catégorie
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }
}
