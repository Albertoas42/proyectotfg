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
            'type' => 'text',
            'is_read' => false,
        ]);

        $this->newMessageContent = '';
        $this->selectChat($this->activeChat->id);
    }

    public function sendOffer()
    {
        $basePrice = ($this->activeChat && $this->activeChat->product)
            ? $this->activeChat->product->price
            : 0;

        $maxPrice = ($basePrice > 0) ? ($basePrice * 10) : 5000;

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

        elseif ($action === 'rejected') {
            $message->update(['offer_status' => 'rejected']);
        }

        elseif ($action === 'counter' && $counterPrice) {
            $message->update(['offer_status' => 'rejected']);

            Message::create([
                'chat_id' => $this->activeChat->id,
                'sender_id' => Auth::id(),
                'content' => "Te hago una contraoferta por " . number_format($counterPrice, 2) . " €.",
                'type' => 'offer',
                'offer_price' => floatval($counterPrice),
                'offer_status' => 'pending',
                'is_read' => false,
            ]);
        }

        $this->selectChat($this->activeChat->id);
    }
    public function closeDeal()
    {
        if (Auth::id() !== $this->activeChat->seller_id) return;

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
            // ... (resto de tu consulta)
            ->get();

        $messages = [];
        $activeChat = null;

        if ($this->activeChat) {
            $activeChat = $this->activeChat;
            $messages = $activeChat->messages()->orderBy('created_at', 'asc')->get();
        }

        return view('livewire.chat-inbox', [
            'chats' => $chats,
            'activeChat' => $activeChat,
            'messages' => $messages
        ]);
    }
}
