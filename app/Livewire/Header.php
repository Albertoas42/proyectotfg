<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Header extends Component
{
    public $currentTab;


    #[On('update-notification-count')]
    public function refreshHeader()
    {
    }

    public function selectTab($tabName)
    {
        $this->dispatch('changeTab', tabName: $tabName);
    }

    public function render()
    {
        $unreadCount = 0;

        if (Auth::check()) {
            $unreadCount = Message::where('is_read', false)
                ->where('sender_id', '!=', Auth::id())
                ->whereHas('chat', function ($query) {
                    $query->where('buyer_id', Auth::id())
                        ->orWhere('seller_id', Auth::id());
                })->count();
        }

        return view('livewire.header', [
            'unreadCount' => $unreadCount
        ]);
    }
}
