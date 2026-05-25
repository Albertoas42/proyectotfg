<?php

namespace App\Livewire;

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
}
