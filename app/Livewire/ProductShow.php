<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Chat; // 🚨 NUEVO: Importamos el modelo Chat para poder gestionarlo
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
     * 🚨 NUEVO: Inicia o recupera una conversación con el vendedor del producto
     */
    public function startChat()
    {
        $authId = Auth::id();
        $sellerId = $this->product->seller_id;
        $productId = $this->product->product_id; // Tu clave primaria personalizada

        // 1. Control de seguridad básico: No puedes chatear contigo mismo
        if ($authId === $sellerId) {
            session()->flash('error', 'No puedes abrir un chat en tu propio anuncio.');
            return;
        }

        // 2. Buscar si ya existe una conversación de este comprador por este producto concreto
        $chat = Chat::where('product_id', $productId)
            ->where('buyer_id', $authId)
            ->first();

        // 3. Si es la primera vez que se contacta, creamos el chat en caliente
        if (!$chat) {
            $chat = Chat::create([
                'product_id' => $productId,
                'buyer_id'   => $authId,
                'seller_id'  => $sellerId,
            ]);
        }

        // 4. Redirigir al alumno a la bandeja de entrada pasándole el ID del chat por la URL
        return $this->redirect(route('chats.inbox', ['chatId' => $chat->id]), navigate: true);
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
