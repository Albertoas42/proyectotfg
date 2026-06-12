<main class="max-w-6xl mx-auto px-4 py-6">

    @if($chats->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-12 text-center max-w-xl mx-auto my-8">
            <div class="w-20 h-20 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center text-4xl mx-auto mb-4">
                📥
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Tu bandeja de entrada está vacía</h3>
            <p class="text-sm text-gray-500 mb-8 leading-relaxed">
                Aquí aparecerán las conversaciones que abras con otros alumnos para comprar libros o material escolar, o cuando se interesen por tus anuncios.
            </p>
            <a href="{{ route('products.index') }}" wire:navigate class="inline-flex items-center gap-2 bg-[#13c1ac] hover:bg-[#0fa895] text-white px-6 py-3 rounded-xl font-bold transition no-underline shadow-xs">
                🌐 Explorar el catálogo
            </a>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden grid grid-cols-1 md:grid-cols-3 h-[calc(100vh-180px)] min-h-[500px]">

            <div class="border-r border-gray-200 flex flex-col h-full bg-gray-50/50">
                <div class="p-4 border-b border-gray-200 bg-white">
                    <h2 class="text-lg font-bold text-gray-800">Mis Conversaciones</h2>
                    <p class="text-xs text-gray-400">Negociaciones de material escolar</p>
                </div>
                <div class="flex-1 overflow-y-auto divide-y divide-gray-100">
                    @foreach($chats as $chat)
                        @php
                            $otherUser = (Auth::id() === $chat->buyer_id) ? $chat->seller : $chat->buyer;
                            $isActive = $activeChat && $activeChat->id === $chat->id;
                        @endphp
                        <button wire:click="selectChat({{ $chat->id }})" class="w-full text-left p-4 flex items-center gap-3 transition hover:bg-gray-100/80 border-none cursor-pointer {{ $isActive ? 'bg-white border-l-4 border-l-[#13c1ac]' : 'bg-transparent' }}">
                            <div class="w-11 h-11 bg-[#13c1ac]/10 text-[#13c1ac] font-bold rounded-full flex items-center justify-center shrink-0">
                                {{ substr($otherUser->first_name ?? 'U', 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0 flex justify-between gap-2">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold text-gray-800 truncate mb-0.5">{{ $otherUser->first_name ?? 'Usuario' }} {{ $otherUser->last_name ?? '' }}</h4>
                                    <p class="text-xs font-semibold text-gray-500 truncate mb-1">📚 {{ $chat->product->title ?? 'Producto' }}</p>
                                    <p class="text-xs text-gray-400 truncate">
                                        @if($chat->lastMessage)
                                            {{ $chat->lastMessage->sender_id === Auth::id() ? 'Tú: ' : '' }}{{ $chat->lastMessage->content }}
                                        @else
                                            <span class="italic text-gray-300">No hay mensajes aún</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="flex flex-col items-end justify-between shrink-0 pb-1">
                                    <span class="text-[10px] text-gray-400">{{ $chat->lastMessage ? $chat->lastMessage->created_at->format('H:i') : '' }}</span>
                                    @if(($chat->unread_messages_count ?? 0) > 0)
                                        <span class="mt-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-[#13c1ac] px-1.5 text-[10px] font-black text-white">
                                            {{ $chat->unread_messages_count }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="md:col-span-2 flex flex-col h-full bg-white">
                @if($activeChat)
                    @php $chatPartner = (Auth::id() === $activeChat->buyer_id) ? $activeChat->seller : $activeChat->buyer; @endphp

                    <div class="p-4 border-b border-gray-200 flex items-center justify-between bg-white shrink-0 gap-4" x-data="{ openOfferModal: false }">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 bg-[#13c1ac] text-white font-bold rounded-full flex items-center justify-center text-sm shrink-0">
                                {{ substr($chatPartner->first_name ?? 'U', 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-bold text-gray-800 leading-tight truncate">{{ $chatPartner->first_name ?? 'Usuario' }} {{ $chatPartner->last_name ?? '' }}</h3>
                                <p class="text-xs text-[#13c1ac] font-medium truncate">Producto: {{ $activeChat->product->title ?? 'Artículo' }} ({{ number_format($activeChat->product->price ?? 0, 2) }} €)</p>
                            </div>
                        </div>

                        <div class="relative shrink-0">
                            <button @click="openOfferModal = !openOfferModal" class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-black px-3 py-2 rounded-xl border-none transition cursor-pointer uppercase tracking-wider">
                                💸 Proponer Oferta
                            </button>
                            <div x-show="openOfferModal" @click.away="openOfferModal = false" x-transition class="absolute right-0 mt-2 bg-white border border-gray-200 rounded-xl p-3 shadow-lg z-30 w-48 space-y-2">
                                <h5 class="text-[10px] font-black uppercase text-gray-400">¿Cuánto ofreces?</h5>
                                <form wire:submit.prevent="sendOffer" @submit="openOfferModal = false" class="flex gap-1.5">
                                    <input type="number" step="0.01" wire:model="offerPrice" placeholder="Precio €" class="w-full bg-gray-50 px-2 py-1.5 text-xs font-bold rounded-lg border border-gray-200 text-center focus:outline-none">
                                    <button type="submit" class="bg-emerald-500 text-white text-xs font-bold px-2.5 rounded-lg border-none cursor-pointer">Enviar</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto p-4 bg-[#f8fafc] space-y-3 flex flex-col">

                        @error('offerPrice')
                        <span class="text-xs bg-red-50 border border-red-200 text-red-600 font-semibold p-2 rounded-xl text-center shadow-xs">
                                ⚠️ {{ $message }}
                            </span>
                        @enderror

                        @foreach($activeChat->messages as $message)
                            @php $isMe = $message->sender_id === Auth::id(); @endphp

                            <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                                @if(isset($message->type) && $message->type === 'offer')

                                    <div class="max-w-[85%] bg-white rounded-2xl border-2 {{ $message->offer_status === 'accepted' ? 'border-emerald-500 bg-emerald-50/10' : ($message->offer_status === 'rejected' ? 'border-gray-200 opacity-60 bg-gray-50/30' : 'border-amber-400 shadow-xs') }} p-4 space-y-3">
                                        <div class="flex items-center gap-2.5">
                                            <span class="text-xl">💰</span>
                                            <div>
                                                <h4 class="text-[10px] font-black uppercase tracking-wider text-gray-400">Propuesta de precio</h4>
                                                <p class="text-xl font-black text-gray-800">{{ number_format($message->offer_price, 2) }} €</p>
                                            </div>
                                        </div>

                                        <div class="text-xs text-gray-500 italic">
                                            {{ $isMe ? 'Has enviado esta oferta.' : 'Te han enviado esta oferta.' }}
                                        </div>

                                        @if($message->offer_status === 'pending')
                                            @if(!$isMe)
                                                <div class="flex flex-col gap-2 pt-1" x-data="{ showCounter: false }">
                                                    <div class="flex gap-1.5 w-full" x-show="!showCounter">
                                                        <button wire:click="handleOffer({{ $message->id }}, 'accepted')" class="flex-1 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-black rounded-xl border-none cursor-pointer uppercase tracking-wider transition">
                                                            ✔️ Aceptar
                                                        </button>
                                                        <button wire:click="handleOffer({{ $message->id }}, 'rejected')" class="flex-1 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-black rounded-xl border-none cursor-pointer uppercase tracking-wider transition">
                                                            ❌ Rechazar
                                                        </button>
                                                        <button @click="showCounter = true" class="flex-1 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-black rounded-xl border-none cursor-pointer uppercase tracking-wider transition">
                                                            🔄 Negociar
                                                        </button>
                                                    </div>

                                                    <div x-show="showCounter" x-transition class="flex items-center gap-1.5 bg-gray-50 p-1.5 rounded-xl border border-gray-200 mt-1">
                                                        <input type="number" step="0.01" id="counter_input_{{ $message->id }}" placeholder="Nuevo precio €" class="w-full bg-white px-2.5 py-1.5 text-xs font-bold rounded-lg border border-gray-200 text-center focus:outline-none">
                                                        <button @click="$wire.handleOffer({{ $message->id }}, 'counter', document.getElementById('counter_input_{{ $message->id }}').value)" class="bg-emerald-500 text-white text-xs font-black px-3 py-1.5 rounded-lg border-none cursor-pointer">
                                                            Enviar
                                                        </button>
                                                        <button @click="showCounter = false" class="bg-gray-300 text-gray-700 text-xs font-bold px-2 py-1.5 rounded-lg border-none cursor-pointer">
                                                            Anular
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="inline-block bg-amber-50 text-amber-800 text-[10px] font-black px-2.5 py-1 rounded-md uppercase tracking-wider animate-pulse">
                                                    ⏳ Esperando respuesta
                                                </span>
                                            @endif
                                        @elseif($message->offer_status === 'accepted')
                                            <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-800 text-[10px] font-black px-2.5 py-1 rounded-md uppercase tracking-wider">
                                                ✅ Aceptada
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-400 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider line-through">
                                                ❌ Rechazada / Superada
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <div class="max-w-[75%] px-4 py-2.5 rounded-2xl text-sm shadow-xs leading-relaxed {{ $isMe ? 'bg-[#13c1ac] text-white rounded-tr-none' : 'bg-white text-gray-800 rounded-tl-none border border-gray-100' }}">
                                        {{ $message->content }}
                                    </div>
                                @endif

                                <span class="text-[9px] text-gray-400 mt-1 px-1">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-4 border-t border-gray-200 bg-white shrink-0">
                        <form wire:submit.prevent="sendMessage" class="flex gap-2">
                            <input type="text" wire:model="newMessageContent" placeholder="Escribe un mensaje seguro..." class="flex-1 bg-gray-50 px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:border-[#13c1ac]">
                            <button type="submit" class="bg-[#13c1ac] hover:bg-[#0fa895] text-white px-6 rounded-xl transition font-bold border-none cursor-pointer flex items-center justify-center shrink-0">
                                Enviar 🚀
                            </button>
                        </form>
                    </div>
                @endif
            </div>

        </div>
    @endif
</main>
