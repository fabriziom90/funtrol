<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\Admin\AdministrationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\RecepyController;
// use App\Http\Controllers\Admin\ProductController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/**
 * Dashboard - accessibile solo a utenti autenticati
 */
Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware('admin')->group(function () {
        Route::prefix('admin')->name('admin.')->group(function() {
            Route::resource('suppliers', SupplierController::class);
            Route::resource('products', ProductController::class);
            Route::resource('recepies', RecepyController::class);
            Route::get('/administration', [AdministrationController::class, 'index'])->name('administration.index');
        });
    });

    Route::get('/production', [ProductionController::class, 'index'])->name('production.index');

    // Route::resource('ricette', RicettaController::class);
    // Route::resource('movimenti', MovimentoMagazzinoController::class);
    // Route::resource('ordini', OrdineController::class);


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * Rotte di autenticazione Breeze
 */
require __DIR__.'/auth.php';
