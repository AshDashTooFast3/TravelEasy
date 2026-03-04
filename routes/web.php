<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KlantBoekingController;
use App\Http\Controllers\MedewerkerController;
use App\Http\Controllers\FactuurController;
use App\Http\Controllers\ProfileController;



Route::get('/', [HomeController::class, 'index'])->name('welcome');


Route::middleware(['auth', 'verified', 'role:administrator,medewerker,manager'])
    ->get('/dashboard', function () {
        return view('dashboard');
    })
    ->name('dashboard');


Route::middleware(['auth', 'verified', 'role:administrator,manager'])->group(function () {
    Route::get('/management-dashboard', [MedewerkerController::class, 'ManagementDashboard'])
        ->name('management-dashboard');

    Route::get('/facturatie', [FactuurController::class, 'index'])
        ->name('facturatie.index');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/mijn-reizen', [KlantBoekingController::class, 'index'])->name('klant.boekingen.index');
    Route::get('/mijn-reizen/nieuw', [KlantBoekingController::class, 'create'])->name('klant.boekingen.create');
    Route::post('/mijn-reizen', [KlantBoekingController::class, 'store'])->name('klant.boekingen.store');
    Route::delete('/mijn-reizen/{id}', [KlantBoekingController::class, 'destroy'])->name('klant.boekingen.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';