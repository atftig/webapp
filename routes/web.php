<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
|
| Qui puoi registrare le route web per la tua applicazione. Queste
| route sono caricate dal RouteServiceProvider all'interno del gruppo
| "web" middleware, offrendo una ricca esperienza di routing.
|
*/

// Route per la homepage
Route::get('/home', function () {
    return view('app.homepage');
})->name('homepage');

// Route per la pagina di aggiunta
Route::get('/aggiunta-page', function () {
    return view('app.aggiunta-page');
})->name('aggiunta-page');

// Route per la pagina di aggiunta (POST)
Route::post('/aggiungi-prodotto', [BuyerController::class, 'store'])->name('store-product');

// Route per il login
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);


//ROTTE PER PROGETTO ISPETTORI
// Route per la pagina pv-page
Route::get('/pv-page', function () {
    return view('app.pv-page');
})->name('pv-page');


// Route per il login
// Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
// Route::post('login', [AuthenticatedSessionController::class, 'store']);

// Route per la dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route per la gestione del profilo
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Carica i file di autenticazione
require __DIR__ . '/auth.php';
