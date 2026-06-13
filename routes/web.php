<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Livewire\AdminReports;
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
    Route::get('/mis-anuncios', \App\Livewire\MyProductsIndex::class)->name('my-products.index');
    Route::get('/favoritos', App\Livewire\FavoritesIndex::class)->name('favorites.index');

    Route::middleware(['auth', 'can:moderar productos'])->group(function () {
        Route::get('/admin/reports', AdminReports::class)->name('admin.reports');
    });
});




require __DIR__.'/auth.php';
