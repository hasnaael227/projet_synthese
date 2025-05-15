<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Routes publiques (login)
Route::get('login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('login', [UserController::class, 'login']);

// Middleware auth pour protéger les routes suivantes
Route::middleware(['auth'])->group(function () {

    // Dashboard accessible uniquement aux admins
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('users.dashboard')->middleware('can:isAdmin');

    // Routes publiques pour l'inscription
    Route::get('register', [UserController::class, 'register'])->name('register');
    Route::post('register', [UserController::class, 'store'])->name('register.store');

    // Logout
    Route::post('logout', [UserController::class, 'logout'])->name('users.logout');

    // Gestion des utilisateurs (admin uniquement)
    Route::middleware('can:isAdmin')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserController::class, 'register'])->name('users.register');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Profile and password (both roles)
    Route::get('profile', [UserController::class, 'profile'])->name('users.profile');
    Route::get('profile/edit', [UserController::class, 'editProfile'])->name('users.editProfile');
    Route::put('profile', [UserController::class, 'updateProfile'])->name('users.updateProfile');

    Route::get('change-password', [UserController::class, 'changePasswordForm'])->name('users.changePasswordForm');
    Route::post('change-password', [UserController::class, 'changePassword'])->name('users.changePassword');

    Route::get('/users/register', [UserController::class, 'create'])->name('users.register');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
});
