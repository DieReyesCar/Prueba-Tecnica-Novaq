<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Ruta raíz - redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas públicas (solo si NO está autenticado)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/recover', [AuthController::class, 'showRecover'])->name('recover');
    Route::post('/recover', [AuthController::class, 'recover']);

    Route::get('/reset/{token}', [AuthController::class, 'showReset'])->name('password.reset');
    Route::post('/reset', [AuthController::class, 'reset'])->name('password.update');
});
 
// Rutas protegidas (solo si está autenticado)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});