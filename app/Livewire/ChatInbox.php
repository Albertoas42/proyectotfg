<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatInbox extends Component
{
    public $activeChat;
    public $newMessageContent = '';
    public $offerPrice = '';

    public function mount($chatId = null)
    {
        if ($chatId) {
            $this->selectChat($chatId);
        }
    }

    public function selectChat($chatId)
    {
        // Cargamos las relaciones frescas en cada interacción
        $this->activeChat = Chat::with(['messages.sender', 'product', 'buyer', 'seller'])->find($chatId);

        if ($this->activeChat) {
            Message::where('chat_id', $chatId)
                ->where('sender_id', '!=', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);

            $this->dispatch('update-notification-count');
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessageContent' => 'required|string|max:1000',
        ]);

        if (!$this->activeChat) return;

        Message::create([
            'chat_id' => $this->activeChat->id,
            'sender_id' => Auth::id(),
            'content' => trim($this->newMessageContent),
            'type' => 'text', // Aseguramos el tipo por defecto
            'is_read' => false,
        ]);

        $this->newMessageContent = '';
        $this->selectChat($this->activeChat->id);
    }

    public function sendOffer()
    {
        // Saneamos la validación para evitar petes si el precio del producto es inestable en local
        $maxPrice = ($this->activeChat && $this->activeChat->product && $this->activeChat->product->price > 0)
            ? $this->activeChat->product->price * 2
            : 1000;

        $this->validate([
            'offerPrice' => 'required|numeric|min:0.50|max:' . $maxPrice,
        ]);

        if (!$this->activeChat) return;

        Message::create([
            'chat_id' => $this->activeChat->id,
            'sender_id' => Auth::id(),
            'content' => "Te ofrezco " . number_format($this->offerPrice, 2) . " € por el producto.",
            'type' => 'offer',
            'offer_price' => $this->offerPrice,
            'offer_status' => 'pending',
            'is_read' => false,
        ]);

        $this->offerPrice = '';
        $this->selectChat($this->activeChat->id);
    }

    public function handleOffer($messageId, $action, $counterPrice = null)
    {
        $message = Message::findOrFail($messageId);

        // 🤝 CASO 1: ACEPTAR LA OFERTA
        if ($action === 'accepted') {
            $message->update(['offer_status' => 'accepted']);

            if ($this->activeChat->product) {
                $this->activeChat->product->update(['price' => $message->offer_price]);
            }

            Message::create([
                'chat_id' => $this->activeChat->id,
                'sender_id' => Auth::id(),
                'content' => "🤝 ¡Trato hecho! El precio del producto se ha actualizado a " . number_format($message->offer_price, 2) . " €.",
                'type' => 'text',
                'is_read' => false,
            ]);
        }

        // ❌ CASO 2: RECHAZAR LA OFERTA
        elseif ($action === 'rejected') {
            $message->update(['offer_status' => 'rejected']);
        }

        // 🔄 CASO 3: CONTRAOFERTAR (NEGOCIAR)
        elseif ($action === 'counter' && $counterPrice) {
            $message->update(['offer_status' => 'rejected']);

            Message::create([
                'chat_id' => $this->activeChat->id,
                'sender_id' => Auth::id(),
                'content' => "Te hago una contraoferta por " . number_format($counterPrice, 2) . " €.",
                'type' => 'offer',
                'offer_price' => floatval($counterPrice), // Nos aseguramos de castearlo a flotante limpio
                'offer_status' => 'pending',
                'is_read' => false,
            ]);
        }

        $this->selectChat($this->activeChat->id);
    }
    public function closeDeal()
    {
        if (Auth::id() !== $this->activeChat->seller_id) return;

        // 1. Marcar como vendido
        $this->activeChat->product->update(['status' => 'sold']);


        \App\Models\Message::create([
            'chat_id'   => $this->activeChat->id,
            'sender_id' => Auth::id(), // El vendedor
            'content'   => '⚠️ El producto ha sido vendido. ¡Acuerdo cerrado!',
            'is_read'   => false,
        ]);

        $this->dispatch('$refresh');
    }
    // En ChatInbox.php
    public function openReviewModal()
    {
        $this->dispatch('open-review-modal',
            productId: $this->activeChat->product_id,
            sellerId: $this->activeChat->seller_id
        );
    }

    public function render()
    {
        $authId = Auth::id();

        $chats = Chat::with(['product', 'buyer', 'seller', 'lastMessage'])
            ->withCount(['messages as unread_messages_count' => function ($query) use ($authId) {
                $query->where('sender_id', '!=', $authId)->where('is_read', false);
            }])
            ->where(function($query) use ($authId) {
                $query->where('buyer_id', $authId)
                    ->orWhere('seller_id', $authId);
            })
            ->get()
            ->sortByDesc(function ($chat) {
                return $chat->lastMessage ? $chat->lastMessage->created_at : $chat->created_at;
            });

        return view('livewire.chat-inbox', [
            'chats' => $chats
        ]);
    }
}
