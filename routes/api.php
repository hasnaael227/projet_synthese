<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ApiCoursController;
use App\Http\Controllers\ApiCategoryController;
use App\Http\Controllers\ApiChapitreController;
use App\Http\Controllers\ApiEtudiantController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/





// // CRUD Utilisateurs
// Route::get('/users', [ApiUserController::class, 'index']);          // Tous les utilisateurs
// Route::post('/users', [ApiUserController::class, 'store']);         // Ajouter un utilisateur
// Route::get('/users/{id}', [ApiUserController::class, 'show']);      // Voir un utilisateur
// Route::put('/users/{id}', [ApiUserController::class, 'update']);    // Modifier un utilisateur
// Route::delete('/users/{id}', [ApiUserController::class, 'destroy']); // Supprimer un utilisateur

// (optionnel) Login / Logout
Route::post('/login', [ApiUserController::class, 'login']);
Route::post('/logout', [ApiUserController::class, 'logout']);

Route::get('/dashboard', [ApiUserController::class, 'dashboard']);


// === Routes pour ADMIN ===
Route::get('/admin/users', [ApiUserController::class, 'index']);            // Lister tous les utilisateurs
Route::post('/admin/users', [ApiUserController::class, 'store']);           // Créer un nouvel utilisateur
Route::get('/admin/users/{id}', [ApiUserController::class, 'show']);        // Afficher un utilisateur
Route::put('/admin/users/{id}', [ApiUserController::class, 'update']);
Route::delete('/admin/users/{id}', [ApiUserController::class, 'destroy']);  // Supprimer un utilisateur

// Gestion du profil
Route::get('/admin/{id}/profile', [ApiUserController::class, 'profile']);          // Voir le profil
Route::put('/admin/updateprofile/{id}', [ApiUserController::class, 'updateAdminProfile']);

// // Changer mot de passe
Route::put('/admin/{id}/updatepassword', [ApiUserController::class, 'updatePassword']);  // Changer mot de passe

// === Routes pour FORMATEUR ===
Route::get('/profile/{id}', [ApiUserController::class, 'profile']);
Route::put('/formateur/updateprofile/{id}', [ApiUserController::class, 'updateProfile']);
Route::put('/formateur/password/{id}', [ApiUserController::class, 'updatePassword']);

// === Déconnexion (pour tous) ===
Route::post('/logout', [ApiUserController::class, 'logout']);


Route::get('/categories', [ApiCategoryController::class, 'index']);          // Liste toutes les catégories
Route::post('/categories', [ApiCategoryController::class, 'store']);         // Crée une nouvelle catégorie
Route::get('/categories/{id}', [ApiCategoryController::class, 'show']);      // Affiche une catégorie par id
Route::put('/categories/{id}', [ApiCategoryController::class, 'update']);    // Met à jour une catégorie par id
Route::delete('/categories/{id}', [ApiCategoryController::class, 'destroy']); // Supprime une catégorie par id



// 📘 Routes CRUD Chapitres
Route::get('/chapitres', [ApiChapitreController::class, 'index']);
Route::post('/chapitres', [ApiChapitreController::class, 'store']);
Route::get('/chapitres/{id}', [ApiChapitreController::class, 'show']);
Route::put('/chapitres/{id}', [ApiChapitreController::class, 'update']);
Route::delete('/chapitres/{id}', [ApiChapitreController::class, 'destroy']);

// 📂 Chapitres par catégorie
Route::get('/chapitres-by-categorie/{id}', [ApiChapitreController::class, 'getByCategorie']);

// ➕ Ajouter un cours à un chapitre
Route::post('/chapitres/{id}/add-cours', [ApiChapitreController::class, 'addCourse']);

// ❌ Supprimer un cours d’un chapitre
Route::delete('/chapitres/{chapitreId}/remove-cours/{coursId}', [ApiChapitreController::class, 'removeCourse']);


Route::get('/cours', [ApiCoursController::class, 'index']);
Route::post('/cours', [ApiCoursController::class, 'store']);
Route::get('/cours/{id}', [ApiCoursController::class, 'show']);
Route::put('/cours/{id}', [ApiCoursController::class, 'update']);
Route::patch('/cours/{id}', [ApiCoursController::class, 'update']);
Route::delete('/cours/{id}', [ApiCoursController::class, 'destroy']);

Route::get('/cours/category/{categoryId}', [ApiCoursController::class, 'getByCategory']);



// Routes D'etudiant
Route::post('/etudiants/login', [ApiEtudiantController::class, 'login']);
Route::post('/etudiants/logout', [ApiEtudiantController::class, 'logout']); // fonctionne même sans auth mais nécessite le token dans l'en-tête

Route::get('/etudiants', [ApiEtudiantController::class, 'index']);
Route::post('/etudiants', [ApiEtudiantController::class, 'store']);
Route::get('/etudiants/{id}', [ApiEtudiantController::class, 'show']);
Route::put('/etudiants/{id}', [ApiEtudiantController::class, 'update']);
Route::delete('/etudiants/{id}', [ApiEtudiantController::class, 'destroy']);