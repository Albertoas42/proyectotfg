<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductShow extends Component
{
    public Product $product;

    // Propiedades para activar el modo edición
    public $isEditing = false;
    public $editTitle;
    public $editPrice;
    public $editDescription;

    // Modifica el método mount para que acepte el parámetro opcional $edit
    public function mount(Product $product, $edit = null)
    {
        $this->product = $product->load(['seller', 'category']);

        $this->editTitle = $product->title;
        $this->editPrice = $product->price;
        $this->editDescription = $product->description;

        // Si en la URL viene la palabra 'editar', activamos el formulario directamente
        if ($edit === 'editar') {
            $this->isEditing = true;
        }
    }

    /**
     * Guarda los cambios del producto (Solo Dueño o Admin)
     */
    public function updateProduct()
    {
        // Comprobación estricta de seguridad en el servidor
        if (Auth::user()->user_id !== $this->product->seller_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para modificar este producto.');
        }

        $this->validate([
            'editTitle' => 'required|min:5|max:100',
            'editPrice' => 'required|numeric|min:0',
            'editDescription' => 'required|min:10',
        ]);

        $this->product->update([
            'title' => $this->editTitle,
            'price' => $this->editPrice,
            'description' => $this->editDescription,
        ]);

        $this->isEditing = false;
        session()->flash('message', '¡Producto actualizado correctamente!');
    }

    /**
     * Elimina el producto de la base de datos (Solo Dueño o Admin)
     */
    public function deleteProduct()
    {
        if (Auth::user()->user_id !== $this->product->seller_id && !Auth::user()->hasRole('admin')) {
            abort(403, 'No tienes permiso para borrar este producto.');
        }

        $this->product->delete();

        session()->flash('message', 'El anuncio ha sido eliminado.');
        return $this->redirect(route('products.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.product-show');
    }
}
