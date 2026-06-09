<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On; // Importamos el atributo para escuchar eventos

class ProductCatalog extends Component
{
    public $tab = 'catalogo';
    public $search = '';

    /**
     * Escucha el evento 'changeTab' lanzado desde el Header
     */
    #[On('changeTab')]
    public function setTab($tabName)
    {
        $this->tab = $tabName;
    }

    public function render()
    {
        $products = Product::with(['seller', 'category'])
            ->where('status', 'available')
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->get();

        return view('livewire.product-catalog', compact('products'));
    }
    public function deleteProduct($productId)
    {
        // Verificación de seguridad en backend usando Spatie
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Acción no autorizada.');
        }

        $product = \App\Models\Product::find($productId);

        if ($product) {
            $product->delete();
            session()->flash('message', 'Producto eliminado por el administrador.');
        }
    }
    public function toggleFavorite($productId)
    {
        if (!Auth::check()) {
            return $this->redirect(route('login'), navigate: true);
        }

        $user = Auth::user();

        // Si ya existe lo quita, si no existe lo añade (función toggle de Eloquent)
        $user->favorites()->toggle($productId);
    }
}
