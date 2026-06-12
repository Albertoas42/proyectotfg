<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewModal extends Component
{
    public $isOpen = false;
    public $productId;
    public $sellerId;
    public $rating = 5;
    public $comment;

    // Escuchamos el evento para abrir el modal
    protected $listeners = ['open-review-modal' => 'openModal'];

    public function openModal($productId, $sellerId)
    {
        $this->productId = $productId;
        $this->sellerId = $sellerId;
        $this->isOpen = true;
    }

    public function save()
    {
        Review::create([
            'product_id' => $this->productId,
            'reviewer_id' => Auth::id(),
            'reviewee_id' => $this->sellerId,
            'rating' => $this->rating,
            'comment' => $this->comment,
        ]);

        $this->isOpen = false;
        session()->flash('message', '¡Gracias por valorar al vendedor!');
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.review-modal');
    }
}
