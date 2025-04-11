<?php

use App\Http\Controllers\API\BlogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\DemandeDevisController;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ProRequestController;
use App\Http\Controllers\API\UserController;

Route::prefix('auth')->controller(RegisterController::class)->group(function() {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [UserController::class, 'me']);
    Route::put('/update-profile', [UserController::class, 'updateProfile']);
    Route::put('/change-password', [UserController::class, 'changePassword']);
});

Route::apiResource('profiles', ProfileController::class);
Route::apiResource('jobs', JobController::class);
Route::apiResource('devis', DemandeDevisController::class);
Route::apiResource('contact', ContactController::class);

Route::apiResource('pro-requests', ProRequestController::class)->only(['index', 'store', 'show']);

Route::patch('/devis/{id}/status', [DemandeDevisController::class, 'updateStatus']);


Route::post('pro-requests/{id}/accept', [ProRequestController::class, 'accept'])->name('pro-requests.accept');
Route::delete('pro-requests/{id}/reject', [ProRequestController::class, 'reject'])->name('pro-requests.reject');

Route::middleware('auth:sanctum')->group( function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    })->name('user'); 
});

// Route publique (accessible sans authentification)
Route::get('blogs', [BlogController::class, 'index']);
Route::get('blogs/{blog}', [BlogController::class, 'show']); // Optionnel si tu veux show public aussi

Route::middleware('auth:sanctum')->group(function () {
    Route::post('blogs', [BlogController::class, 'store']);
    Route::put('blogs/{blog}', [BlogController::class, 'update']);
    Route::delete('blogs/{blog}', [BlogController::class, 'destroy']);
});

