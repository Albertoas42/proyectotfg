<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Livewire\ChatInbox;
use App\Livewire\ProductCatalog;
use App\Livewire\ProductCreate;
use App\Livewire\ProductShow;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/productos', ProductCatalog::class)->name('products.index');
    Route::get('/productos/subir', ProductCreate::class)->name('products.create');
    Route::get('/productos/{product}/{edit?}', ProductShow::class)->name('products.show');


    Route::get('/perfil/{user}', \App\Livewire\UserProfile::class)->name('user.profile');

    Route::get('/mensajes/{chatId?}', ChatInbox::class)->name('chats.inbox');
    Route::get('/mis-anuncios', ProductCatalog::class)->name('my-products.index');
    Route::get('/favoritos', App\Livewire\FavoritesIndex::class)->name('favorites.index');


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
