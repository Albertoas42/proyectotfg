<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message; // 🚨 Importamos el modelo Message
use Illuminate\Support\Facades\Auth;

class Header extends Component
{
    // Mantenemos tu propiedad pública para la pestaña activa
    public $currentTab;

    // 🚨 NUEVO: Escuchamos el evento para refrescar el contador en tiempo real
    protected $listeners = ['refreshNotifications' => '$refresh'];

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
