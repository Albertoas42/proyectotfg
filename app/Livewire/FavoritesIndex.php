<?php

namespace App\Livewire; // 🚨 Asegúrate de que quede solo un 'App'

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FavoritesIndex extends Component
{
    public function toggleFavorite($productId)
    {
        Auth::user()->favorites()->toggle($productId);
    }

    public function render()
    {
        // Obtenemos los productos favoritos del alumno auténticado
        $favoriteProducts = Auth::user()->favorites()->with(['category', 'seller'])->get();

        return view('livewire.favorites-index', [
            'products' => $favoriteProducts
        ]);
    }
}
