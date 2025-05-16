<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

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