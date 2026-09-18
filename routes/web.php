<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// Public pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/evenements', [EventController::class, 'index'])->name('events.index');
Route::get('/evenements/{slug}', [EventController::class, 'show'])->name('events.show');
Route::get('/mentions-legales', [LegalController::class, 'mentions'])->name('legal.mentions');
Route::get('/politique-de-confidentialite', [LegalController::class, 'privacy'])->name('legal.privacy');

// Reservation (auth-protected; unauthenticated users are redirected to login then back)
Route::middleware('auth')->group(function () {
    Route::get('/reservations', fn () => view('reservation.index'))->name('reservation.create');
    Route::get('/mes-reservations', [ReservationController::class, 'index'])->name('reservation.history');
    Route::post('/mes-reservations/{reservation}/annuler', [ReservationController::class, 'cancel'])->name('reservation.cancel');
});

// Authenticated area
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
