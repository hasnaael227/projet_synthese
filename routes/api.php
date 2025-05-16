<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;




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





// CRUD Utilisateurs
Route::get('/users', [ApiUserController::class, 'index']);          // Tous les utilisateurs
Route::post('/users', [ApiUserController::class, 'store']);         // Ajouter un utilisateur
Route::get('/users/{id}', [ApiUserController::class, 'show']);      // Voir un utilisateur
Route::put('/users/{id}', [ApiUserController::class, 'update']);    // Modifier un utilisateur
Route::delete('/users/{id}', [ApiUserController::class, 'destroy']); // Supprimer un utilisateur

// Gestion du profil
Route::get('/users/{id}/profile', [ApiUserController::class, 'profile']);          // Voir le profil
Route::put('/users/{id}/profile', [ApiUserController::class, 'updateProfile']);    // Modifier le profil

// Changer mot de passe
Route::put('/users/{id}/password', [ApiUserController::class, 'updatePassword']);  // Changer mot de passe

// (optionnel) Login / Logout
Route::post('/login', [ApiUserController::class, 'login']);
Route::post('/logout', [ApiUserController::class, 'logout']);


