<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ApiCategoryController;




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
Route::get('/categories/{category}', [ApiCategoryController::class, 'show']); // Affiche une catégorie spécifique
Route::put('/categories/{category}', [ApiCategoryController::class, 'update']); // Met à jour une catégorie
Route::patch('/categories/{category}', [ApiCategoryController::class, 'update']); // Met à jour partiellement une catégorie
Route::delete('/categories/{category}', [ApiCategoryController::class, 'destroy']); // Supprime une catégorie

