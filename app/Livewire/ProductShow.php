<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads; // 👈 1. NECESARIO PARA LAS FOTOS
use App\Models\Product;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProductShow extends Component
{
    use WithFileUploads; // 👈 2. AÑADE ESTO

    public Product $product;

    public $isEditing = false;
    public $editTitle;
    public $editPrice;
    public $editDescription;
    public $editLocation; // 👈 3. NUEVA PROPIEDAD
    public $editImage;    // 👈 4. NUEVA PROPIEDAD

    public function mount(Product $product, $edit = null)
    {
        $this->product = $product->load(['seller', 'category']);

        $this->editTitle = $product->title;
        $this->editPrice = $product->price;
        $this->editDescription = $product->description;
        $this->editLocation = $product->location; // 👈 5. Inicializar

        if ($edit === 'editar') {
            $this->isEditing = true;
        }
    }

    public function startChat()
    {
        // ... (tu lógica de startChat se mantiene igual)
        $authId = Auth::id();
        $sellerId = $this->product->seller_id;
        $productId = $this->product->product_id;

        if ($authId === $sellerId) {
            session()->flash('error', 'No puedes abrir un chat en tu propio anuncio.');
            return;
        }

        $chat = Chat::where('product_id', $productId)->where('buyer_id', $authId)->first();

        if (!$chat) {
            $chat = Chat::create(['product_id' => $productId, 'buyer_id' => $authId, 'seller_id' => $sellerId]);
        }

        return $this->redirect(route('chats.inbox', ['chatId' => $chat->id]), navigate: true);
    }

    public function updateProduct()
    {
        if (Auth::user()->user_id !== $this->product->seller_id && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $this->validate([
            'editTitle' => 'required|min:5|max:100',
            'editPrice' => 'required|numeric|min:0',
            'editDescription' => 'required|min:10',
            'editLocation' => 'required|string', // 👈 6. Validar
            'editImage' => 'nullable|image|max:2048', // 👈 6. Validar
        ]);

        // Lógica de actualización
        $updateData = [
            'title' => $this->editTitle,
            'price' => $this->editPrice,
            'description' => $this->editDescription,
            'location' => $this->editLocation, // 👈 7. Guardar
        ];

        // Lógica de la imagen
        if ($this->editImage) {
            $storedPath = $this->editImage->store('products', 'public');
            $updateData['image_url'] = 'storage/' . $storedPath;
        }

        $this->product->update($updateData);

        $this->isEditing = false;
        session()->flash('message', '¡Producto actualizado correctamente!');
    }

    public function deleteProduct()
    {
        if (Auth::user()->user_id !== $this->product->seller_id && !Auth::user()->hasRole('admin')) {
            abort(403);
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
