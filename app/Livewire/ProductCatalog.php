<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Product;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class ProductCatalog extends Component
{
    use WithPagination;

    public $tab = 'catalogo';

    public $search = '';
    public $selectedCategory = '';
    public $selectedCondition = '';

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
            ->search($this->search)
            ->ofCategory($this->selectedCategory)
            ->ofCondition($this->selectedCondition)
            ->latest()
            ->paginate(8);

        return view('livewire.product-catalog', compact('products'));
    }
    public function deleteProduct($productId)
    {
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
