<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ProductShow extends Component
{
    use WithFileUploads;

    public Product $product;
    public $isEditing = false;

    public $editTitle;
    public $editPrice;
    public $editDescription;
    public $editLocation;
    public $editImage;

    public function mount(Product $product)
    {
        $this->product = $product->load(['seller', 'category']);
    }

    public function loadEditData()
    {
        $this->editTitle = $this->product->title;
        $this->editPrice = $this->product->price;
        $this->editDescription = $this->product->description;
        $this->editLocation = $this->product->location;
        $this->isEditing = true;
    }

    public function updateProduct()
    {
        $this->validate([
            'editTitle' => 'required|min:5|max:100',
            'editPrice' => 'required|numeric|min:0',
            'editDescription' => 'required|min:10',
            'editLocation' => 'required|string',
            'editImage' => 'nullable|image|max:2048',
        ]);

        $updateData = [
            'title' => $this->editTitle,
            'price' => $this->editPrice,
            'description' => $this->editDescription,
            'location' => $this->editLocation,
        ];

        if ($this->editImage) {
            $storedPath = $this->editImage->store('products', 'public');
            $updateData['image_url'] = 'storage/' . $storedPath;
        }

        $this->product->update($updateData);
        $this->isEditing = false;
        session()->flash('message', '¡Producto actualizado correctamente!');
    }

    public function confirmDelete()
    {
        $this->js("if(confirm('¿Seguro que quieres borrar este anuncio?')) { \$wire.deleteProduct(); }");
    }

    public function deleteProduct()
    {
        $this->product->delete();
        return redirect()->route('products.index')->with('message', 'Producto eliminado.');
    }
    public function startChat()
    {
        $authId = Auth::id();
        $sellerId = $this->product->seller_id;
        $productId = $this->product->product_id;

        if ($authId === $sellerId) {
            session()->flash('error', 'No puedes abrir un chat en tu propio anuncio.');
            return;
        }

        $chat = Chat::where('product_id', $productId)
            ->where('buyer_id', $authId)
            ->first();

        if (!$chat) {
            $chat = Chat::create([
                'product_id' => $productId,
                'buyer_id' => $authId,
                'seller_id' => $sellerId
            ]);
        }

        return $this->redirect(route('chats.inbox', ['chatId' => $chat->id]), navigate: true);
    }

    public function render()
    {
        return view('livewire.product-show');
    }
}
