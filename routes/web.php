<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Livewire\ProductCatalog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Cada sección es una ruta real e independiente
    Route::get('/productos', ProductCatalog::class)->name('products.index');

    // Provisionales para que no te dé error hoy (puedes apuntarlas al catálogo de momento)
    Route::get('/mensajes', ProductCatalog::class)->name('messages.index');
    Route::get('/mis-anuncios', ProductCatalog::class)->name('my-products.index');
    Route::get('/favoritos', ProductCatalog::class)->name('favorites.index');

});
Route::middleware('dashboard')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
