<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KlantBoekingController;
use App\Http\Controllers\MedewerkerController;
use App\Http\Controllers\FactuurController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BoekingController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AccommodatieController;

Route::get('/', [HomeController::class, 'index'])->name('welcome');

// alle medewerkers kunnen deze pagina zien
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'role:'])->name('dashboard');

Route::get('/accommodatie', [AccommodatieController::class, 'index'])->name('accommodatie.index');
Route::get('/accommodatie/{id}/edit', [AccommodatieController::class, 'edit'])->name('accommodaties.edit');
Route::middleware(['auth', 'verified', 'role:administrator,manager'])->group(function () {
    Route::patch('/accommodatie/{id}', [AccommodatieController::class, 'update'])->name('accommodaties.update');
});
Route::middleware(['auth', 'verified', 'role:administrator,manager'])->group(function () {
    Route::get('/accommodatie/create', [AccommodatieController::class, 'create'])->name('accommodaties.create');
    Route::post('/accommodatie', [AccommodatieController::class, 'store'])->name('accommodaties.store');
});

// Alleen Administrators en Managers kunnen deze pagina zien
Route::middleware(['auth', 'verified', 'role:administrator,manager'])->group(function () {
    Route::get('/management-dashboard', [MedewerkerController::class, 'ManagementDashboard'])->name('management-dashboard');
    Route::get('/facturatie', [FactuurController::class, 'index'])->name('facturatie.index');
    Route::get('/boekingen', [BoekingController::class, 'index'])->name('boekingen.index');

});
   Route::get('/reis', [KlantBoekingController::class, 'index'])->name('reis.index');
Route::middleware(['auth', 'verified', 'role:passagier,administrator,manager,financieelmedewerker,reisadviseur'])->group(function () {
    // Reis overzicht
 
        Route::get('/reis/nieuw', [KlantBoekingController::class, 'create'])->name('reis.create');
    Route::get('/reis/map', [KlantBoekingController::class, 'map'])->name('reis.map');
    Route::get('/reis/{id}', [KlantBoekingController::class, 'show'])->name('reis.show');
        Route::post('/reis', [KlantBoekingController::class, 'store'])->name('reis.store');
    Route::delete('/reis/{id}', [KlantBoekingController::class, 'destroy'])->name('reis.destroy');
    // Ticket overzicht 
    Route::get('/tickets', [TicketController::class, 'index'])->name('ticket.index');
    Route::get('/ticket/{id}', [TicketController::class, 'show'])->name('ticket.show');
    Route::post('/reis/{id}/boeken', [KlantBoekingController::class, 'ReisBoeken'])->name('reis.boeken');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';