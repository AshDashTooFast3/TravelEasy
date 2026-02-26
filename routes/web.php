<?php

use App\Http\Controllers\MedewerkerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

// alle medewerkers kunnen deze pagina zien
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:administrator,medewerker,manager'])->name('dashboard');

// Alleen Administrators en Managers kunnen deze pagina zien
Route::middleware(['auth', 'verified', 'role:administrator,manager'])->group(function () {
    Route::get('/management-dashboard', [MedewerkerController::class, 'ManagementDashboard'])->name('management-dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';