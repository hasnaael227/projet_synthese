<?php

use App\Models\Cours;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapitreController;
use App\Http\Controllers\EtudiantController;

// ===== Authentification =====

Route::get('/login', [UserController::class, 'loginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.submit');
Route::post('/logout', [UserController::class, 'logout'])->name('users.logout');

// ===== Dashboards =====

Route::get('/admin/dashboard', [UserController::class, 'dashboard'])->name('users.dashboard');
Route::get('/formateur/dashboard', [UserController::class, 'dashboard'])->name('formateurs.dashboard');

Route::prefix('formateur')->name('formateurs.')->group(function () {
    Route::get('/profile', [UserController::class, 'Profile'])->name('profile');
    Route::get('/edit', [UserController::class, 'edit'])->name('edit');
    Route::post('/edit', [UserController::class, 'Update'])->name('update');
    Route::get('/show/{id}', [UserController::class, 'Show'])->name('show');
    Route::get('/change-password', [UserController::class, 'changePassword'])->name('change_password_form');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('change_password');
});

// ===== Gestion des utilisateurs (admin) =====
// Suppression du middleware auth pour test ou accès libre

// Routes pour création d'utilisateur
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users', [UserController::class, 'index']); // pour lister ou afficher

// Routes pour gestion des utilisateurs
Route::get('/users/liste', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// ===== Profil utilisateur connecté =====

Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('users.editProfile');
Route::put('/profile', [UserController::class, 'updateProfile'])->name('users.updateProfile');

// ===== Changer mot de passe (formateur) =====
Route::get('/users2/change-password', [UserController::class, 'changePassword'])->middleware('auth')->name('users.change_password');
Route::post('/users2/change-password', [UserController::class, 'updatePassword'])->middleware('auth')->name('users.update_password');
Route::get('/change-password', [UserController::class, 'changePassword'])->name('users.change_Password');
Route::put('/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');


// Afficher la liste des catégories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// Afficher le formulaire de création d'une catégorie
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');

// Enregistrer une nouvelle catégorie
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

// Afficher les détails d'une catégorie
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Afficher le formulaire d'édition d'une catégorie
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');

// Mettre à jour une catégorie
Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

// Supprimer une catégorie
Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');



// Liste de tous les chapitres
Route::get('chapitres', [ChapitreController::class, 'index'])->name('chapitres.index');

// Formulaire de création
Route::get('chapitres/create', [ChapitreController::class, 'create'])->name('chapitres.create');

// Stocker un nouveau chapitre
Route::post('chapitres', [ChapitreController::class, 'store'])->name('chapitres.store');

// Afficher un chapitre spécifique par id
Route::get('chapitres/{id}', [ChapitreController::class, 'show'])->name('chapitres.show');

// Formulaire d’édition par id
Route::get('chapitres/{id}/edit', [ChapitreController::class, 'edit'])->name('chapitres.edit');

// Mettre à jour un chapitre par id
Route::put('chapitres/{id}', [ChapitreController::class, 'update'])->name('chapitres.update');

// Supprimer un chapitre par id
Route::delete('chapitres/{id}', [ChapitreController::class, 'destroy'])->name('chapitres.destroy');



// Cours CRUD
Route::get('/cours', [CoursController::class, 'index'])->name('cours.index');             // Afficher tous les cours
Route::get('/cours/create', [CoursController::class, 'create'])->name('cours.create');     // Formulaire d’ajout
Route::post('/cours', [CoursController::class, 'store'])->name('cours.store');             // Enregistrer le cours
Route::get('/cours/{id}', [CoursController::class, 'show'])->name('cours.show');           // Afficher un cours spécifique
Route::get('/cours/{id}/edit', [CoursController::class, 'edit'])->name('cours.edit');      // Formulaire de modification
Route::put('/cours/{id}', [CoursController::class, 'update'])->name('cours.update');       // Enregistrer les modifications
Route::delete('/cours/{id}', [CoursController::class, 'destroy'])->name('cours.destroy');  // Supprimer un cours

// Route AJAX pour charger les chapitres par catégorie
// Route::get('/chapitres-by-categorie2/{id}', [CoursController::class, 'getChapitresByCategorie']);
Route::get('getByCategory/{categoryId}', [CoursController::class, 'getByCategory']);

Route::get('/chapitres/{chapitre}/add-course', [ChapitreController::class, 'addCourseForm'])->name('chapitres.addCourseForm');
Route::post('/chapitres/{chapitre}/add-course', [ChapitreController::class, 'addCourse'])->name('chapitres.addCourse');
Route::delete('/chapitres/{chapitre}/cours/{cours}', [ChapitreController::class, 'removeCourse'])->name('chapitres.removeCourse');



// ✅ Login (nommé "inscription")
Route::get('/login/inscription', [EtudiantController::class, 'showLoginForm'])->name('login.form');
Route::post('/login/etudiant', [EtudiantController::class, 'login'])->name('login.submit');
Route::post('/logout/etudiant', [EtudiantController::class, 'logout'])->name('logout');

// ✅ CRUD Étudiants
Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');
Route::get('/etudiants/create', [EtudiantController::class, 'create'])->name('etudiants.create');
Route::post('/etudiants', [EtudiantController::class, 'store'])->name('etudiants.store');
Route::get('/etudiants/{etudiant}', [EtudiantController::class, 'show'])->name('etudiants.show');
Route::get('/etudiants/{etudiant}/edit', [EtudiantController::class, 'edit'])->name('etudiants.edit');
Route::put('/etudiants/{etudiant}', [EtudiantController::class, 'update'])->name('etudiants.update');
Route::delete('/etudiants/{etudiant}', [EtudiantController::class, 'destroy'])->name('etudiants.destroy');
