<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserProfile extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user->load(['profile', 'reviewsReceived.reviewer', 'products' => function($query) {
            $query->where('status', 'available');
        }]);
    }

    public function render()
    {
        return view('livewire.user-profile', [
            'averageRating' => $this->user->averageRating(),
            'totalReviews' => $this->user->reviewsReceived()->count(),
            'products' => $this->user->products
        ]);
    }

}
