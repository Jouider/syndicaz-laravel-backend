<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\DemandeDevisController;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\ProRequestController;

Route::prefix('auth')->controller(RegisterController::class)->group(function() {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});

Route::apiResource('profiles', ProfileController::class);
Route::apiResource('jobs', JobController::class);
Route::apiResource('devis', DemandeDevisController::class);
Route::apiResource('contact', ContactController::class);

Route::apiResource('pro-requests', ProRequestController::class)->only(['index', 'store', 'show']);

Route::post('pro-requests/{id}/accept', [ProRequestController::class, 'accept'])->name('pro-requests.accept');
Route::delete('pro-requests/{id}/reject', [ProRequestController::class, 'reject'])->name('pro-requests.reject');

Route::middleware('auth:sanctum')->group( function () {
    Route::apiResource('blogs', BlogController::class);
    Route::get('user', function (Request $request) {
        return $request->user();
    })->name('user'); 
});
