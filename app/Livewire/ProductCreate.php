<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductCreate extends Component
{
    use WithFileUploads;

    public $title;
    public $price;
    public $category_id;
    public $item_condition = 'good';
    public $description;
    public $image;
    public $location = 'Patio Central'; // 📍 Propiedad añadida con valor por defecto

    protected $rules = [
        'title' => 'required|string|min:5|max:100',
        'price' => 'required|numeric|min:0|max:9999',
        'category_id' => 'required|exists:categories,category_id',
        'item_condition' => 'required|in:new,good,worn',
        'description' => 'required|string|min:10|max:1000',
        'image' => 'nullable|image|max:2048',
        'location' => 'required|string|max:100', // 📍 Validamos la localización
    ];

    public function saveProduct()
    {
        $this->validate();

        $storedPath = null;
        if ($this->image) {
            $storedPath = $this->image->store('products', 'public');
        }

        Product::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'item_condition' => $this->item_condition,
            'image_url' => $storedPath ? 'storage/' . $storedPath : null,
            'status' => 'available',
            'category_id' => $this->category_id,
            'seller_id' => Auth::id(),
            'buyer_id' => null,
            'location' => $this->location, // 📍 Guardamos el punto de encuentro en la base de datos
        ]);

        session()->flash('message', '¡Anuncio publicado con éxito en el instituto!');

        return $this->redirect(route('products.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.product-create', [
            'categories' => Category::all()
        ]);
    }
}
