<?php

use App\Http\Controllers\MedewerkerController;
use App\Http\Controllers\FactuurController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BoekingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccommodatieController;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

// alle medewerkers kunnen deze pagina zien
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:administrator,medewerker,manager'])->name('dashboard');

Route::get('/accommodatie', [AccommodatieController::class, 'index'])->name('accommodatie.index');
Route::get('/accommodatie/{id}/edit', [AccommodatieController::class, 'edit'])->name('accommodaties.edit');
Route::middleware(['auth', 'verified', 'role:administrator,manager'])->group(function () {
    Route::patch('/accommodatie/{id}', [AccommodatieController::class, 'update'])->name('accommodaties.update');
});

// Alleen Administrators en Managers kunnen deze pagina zien
Route::middleware(['auth', 'verified', 'role:administrator,manager'])->group(function () {
    Route::get('/management-dashboard', [MedewerkerController::class, 'ManagementDashboard'])->name('management-dashboard');
    Route::get('/boekingen', [BoekingController::class, 'index'])->name('boekingen.index');
    Route::get('/facturatie', [FactuurController::class, 'index'])->name('facturatie.index');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';