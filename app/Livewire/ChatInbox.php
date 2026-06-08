<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatInbox extends Component
{
    public $activeChat = null; // Almacena el objeto del chat seleccionado actualmente
    public $newMessageContent = ''; // Enlazado al input de texto del formulario

    public function mount($chatId = null)
    {
        if ($chatId) {
            $this->selectChat($chatId);
        }
    }

    // Al pinchar en un chat del listado izquierdo
    public function selectChat($chatId)
    {
        $this->activeChat = Chat::with(['messages.sender', 'product', 'buyer', 'seller'])->find($chatId);

        if ($this->activeChat) {
            Message::where('chat_id', $chatId)
                ->where('sender_id', '!=', Auth::id())
                ->update(['is_read' => true]);
        }
    }

    // Al pulsar el botón de Enviar o dar a Enter en el formulario
    public function sendMessage()
    {
        // Validar que el mensaje no vaya vacío
        $this->validate([
            'newMessageContent' => 'required|string|max:1000',
        ]);

        if (!$this->activeChat) {
            return;
        }

        // 1. Guardar el mensaje en la base de datos
        Message::create([
            'chat_id' => $this->activeChat->id, // Usamos 'id' estándar
            'sender_id' => Auth::id(),
            'content' => trim($this->newMessageContent),
            'is_read' => false,
        ]);

        // 2. Limpiar el campo de texto de la pantalla de forma inmediata
        $this->newMessageContent = '';

        // 3. Refrescar el chat activo para que pinte el nuevo mensaje al instante
        $this->selectChat($this->activeChat->id);
    }

    public function render()
    {
        $authId = Auth::id();

        // Recuperar todos los chats del usuario ordenados por el más reciente
        $chats = Chat::with(['product', 'buyer', 'seller', 'lastMessage'])
            ->where('buyer_id', $authId)
            ->orWhere('seller_id', $authId)
            ->get()
            ->sortByDesc(function ($chat) {
                return $chat->lastMessage ? $chat->lastMessage->created_at : $chat->created_at;
            });

        return view('livewire.chat-inbox', [
            'chats' => $chats
        ]);
    }
}
