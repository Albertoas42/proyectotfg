<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\WithPagination; // 🚨 Asegúrate de que esta línea esté así

class ProductCatalog extends Component
{
    use WithPagination; // Activa la paginación de Livewire

    public $tab = 'catalogo';

    public $search = '';
    public $selectedCategory = '';
    public $selectedCondition = '';

    /**
     * 🚀 SOLUCIÓN: Cambiamos $this->resetPage() por $this->gotoPage(1)
     * Esto obliga a Livewire a volver a la primera página de forma segura
     * en cuanto cambie cualquier filtro del catálogo.
     */
    public function updatingSearch() { $this->gotoPage(1); }
    public function updatingSelectedCategory() { $this->gotoPage(1); }
    public function updatingSelectedCondition() { $this->gotoPage(1); }

    #[On('changeTab')]
    public function setTab($tabName)
    {
        $this->tab = $tabName;
    }

    public function render()
    {
        $products = Product::query()
            ->with(['seller', 'category'])
            // ✂️ Hemos quitado ->available() de aquí para que entren reservados y vendidos
            ->search($this->search)
            ->ofCategory($this->selectedCategory)
            ->ofCondition($this->selectedCondition)
            ->latest()
            ->paginate(8);

        return view('livewire.product-catalog', compact('products'));
    }
    public function deleteProduct($productId)
    {
        // Verificación de seguridad en backend usando Spatie o Roles
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Acción no autorizada.');
        }

        $product = Product::find($productId);

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
        $user->favorites()->toggle($productId);
    }
}
