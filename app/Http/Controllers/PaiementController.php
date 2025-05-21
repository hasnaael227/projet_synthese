<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Etudiant;
use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{

// Afficher le formulaire de paiement
public function create()
{
    $etudiant = Etudiant::find(1); 
    $categorie = Category::find(1); 

    // Vérifie bien que $categorie n'est pas null !
    if (!$categorie) {
        abort(404, "Catégorie non trouvée");
    }

    return view('paiements.create', compact('etudiant', 'categorie'));
}

    public function store(Request $request)
{
    // Validate the request
    $request->validate([
    'etudiant_id' => 'required|exists:etudiants,id',
    'category_id' => 'required|exists:categories,id',
    'cin' => 'required|string|max:20',
    'numero_carte' => 'required|string|max:20',
    'date_expiration' => 'required|string|regex:/^\d{4}-\d{2}$/',
    'code_securite' => 'required|string|max:5',
]);

Paiement::create($request->only([
    'etudiant_id',
    'category_id',
    'cin',
    'numero_carte',
    'date_expiration',
    'code_securite',
]));

    // Redirect to the index page with success message
    return redirect()->route('paiements.index')->with('success', 'Paiement enregistré avec succès.');
}

    // Lister tous les paiements
    public function index()
    {
        $paiements = Paiement::with('category', 'etudiant')->latest()->get();
        return view('paiements.index', compact('paiements'));
    }

    // Afficher les détails d'un paiement (optionnel)
        public function show($id)
    {
        $paiement = Paiement::findOrFail($id);
        return view('paiements.show', compact('paiement'));
    }

    public function payerCategorie(Request $request)
{
    $request->validate([
        'etudiant_id' => 'required|exists:etudiants,id',
        'category_id' => 'required|exists:categories,id',
        'cin' => 'required|string|max:20',
        'numero_carte' => 'required|string|max:20',
        'date_expiration' => 'required|date',
        'code_securite' => 'required|string|max:5',
    ]);

    $paiement = Paiement::create($request->only([
        'etudiant_id',
        'category_id',
        'cin',
        'numero_carte',
        'date_expiration',
        'code_securite',
    ]));

    return response()->json([
        'message' => 'Paiement enregistré avec succès.',
        'paiement' => $paiement,
    ], 201);
}

public function payer(Request $request, Category $categorie)
{
    // Récupérer l'id de l'étudiant depuis la requête
    $etudiant_id = $request->input('etudiant_id');

    if (!$etudiant_id) {
        return redirect()->back()->with('error', 'ID étudiant manquant.');
    }

    $etudiant = Etudiant::find($etudiant_id);

    if (!$etudiant) {
        return redirect()->back()->with('error', 'Étudiant non trouvé.');
    }

    // Vérifier si paiement existe déjà
    if ($etudiant->categories()->where('category_id', $categorie->id)->exists()) {
        return redirect()->back()->with('error', 'Vous avez déjà payé cette catégorie.');
    }

    // Attacher la catégorie à l'étudiant
    $etudiant->categories()->attach($categorie->id);

    return redirect()->back()->with('success', 'Paiement effectué avec succès !');
}

}



