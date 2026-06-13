<?php

namespace App\Livewire;

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
        $favoriteProducts = Auth::user()->favorites()->with(['category', 'seller'])->get();

        return view('livewire.favorites-index', [
            'products' => $favoriteProducts
        ]);
    }
}
