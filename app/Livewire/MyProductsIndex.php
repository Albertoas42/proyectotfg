<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class MyProductsIndex extends Component
{
    // Función para borrar un anuncio directamente desde la lista
    public function deleteProduct($productId)
    {
        $product = Product::where('seller_id', Auth::id())
            ->where('product_id', $productId)
            ->firstOrFail();

        $product->delete();

        session()->flash('message', 'Anuncio eliminado correctamente.');
    }
    public function changeProductStatus($productId, $newStatus)
    {
        $product = Product::where('product_id', $productId)
            ->where('seller_id', Auth::id())
            ->firstOrFail();

        $product->update([
            'status' => trim(strtolower($newStatus))
        ]);

        session()->flash('message', "Estado actualizado.");
    }

    public function render()
    {
        $myProducts = Product::where('seller_id', Auth::id())
            ->with('category')
            ->latest()
            ->get();

        return view('livewire.my-products-index', [
            'products' => $myProducts
        ]);
    }
}
