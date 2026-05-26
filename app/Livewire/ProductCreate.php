<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category; // Asegúrate de tener este modelo
use Illuminate\Support\Facades\Auth;

class ProductCreate extends Component
{
    // Propiedades del formulario
    public $title = '';
    public $description = '';
    public $price = '';
    public $category_id = '';
    public $item_condition = 'good'; // Por defecto 'Bueno'

    // Reglas de validación
    protected $rules = [
        'title' => 'required|min:5|max:100',
        'description' => 'required|min:10',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,category_id',
        'item_condition' => 'required|in:new,good,used',
    ];

    public function save()
    {
        $this->validate();

        Product::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category_id,
            'item_condition' => $this->item_condition,
            'seller_id' => Auth::user()->user_id, // El usuario logueado es el vendedor
            'status' => 'available',
        ]);

        // Mensaje de éxito y redirección index
        session()->flash('message', '¡Anuncio publicado con éxito! 🎉');
        return $this->redirect(route('products.index'), navigate: true);
    }

    public function render()
    {
        // Pasamos las categorías a la vista para el desplegable
        return view('livewire.product-create', [
            'categories' => Category::all()
        ]);
    }
}
