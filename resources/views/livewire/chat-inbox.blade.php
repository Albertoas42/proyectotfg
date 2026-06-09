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

            <a href="{{ route('products.index') }}" wire:navigate
               class="inline-flex items-center gap-2 bg-[#13c1ac] hover:bg-[#0fa895] text-white px-6 py-3 rounded-xl font-bold transition no-underline shadow-xs">
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

                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-baseline mb-0.5">
                                    <h4 class="text-sm font-bold text-gray-800 truncate">{{ $otherUser->first_name ?? 'Usuario' }} {{ $otherUser->last_name ?? '' }}</h4>
                                    <span class="text-[10px] text-gray-400 shrink-0">
                                        {{ $chat->lastMessage ? $chat->lastMessage->created_at->format('H:i') : '' }}
                                    </span>
                                </div>
                                <p class="text-xs font-semibold text-gray-500 truncate mb-1">
                                    📚 {{ $chat->product->title ?? 'Producto' }}
                                </p>
                                <p class="text-xs text-gray-400 truncate">
                                    @if($chat->lastMessage)
                                        {{ $chat->lastMessage->sender_id === Auth::id() ? 'Tú: ' : '' }}{{ $chat->lastMessage->content }}
                                    @else
                                        <span class="italic text-gray-300">No hay mensajes aún</span>
                                    @endif
                                </p>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="md:col-span-2 flex flex-col h-full bg-white">
                @if($activeChat)
                    @php
                        $chatPartner = (Auth::id() === $activeChat->buyer_id) ? $activeChat->seller : $activeChat->buyer;
                    @endphp

                    <div class="p-4 border-b border-gray-200 flex items-center justify-between bg-white shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-[#13c1ac] text-white font-bold rounded-full flex items-center justify-center text-sm">
                                {{ substr($chatPartner->first_name ?? 'U', 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 leading-tight">{{ $chatPartner->first_name ?? 'Usuario' }} {{ $chatPartner->last_name ?? '' }}</h3>
                                <p class="text-xs text-[#13c1ac] font-medium">Producto: {{ $activeChat->product->title ?? 'Artículo' }} ({{ number_format($activeChat->product->price ?? 0, 2) }} €)</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto p-4 bg-[#f8fafc] space-y-3 flex flex-col">
                        @foreach($activeChat->messages as $message)
                            @php $isMe = $message->sender_id === Auth::id(); @endphp

                            <div class="flex flex-col {{ $isMe ? 'items-end' : 'items-start' }}">
                                <div class="max-w-[75%] px-4 py-2.5 rounded-2xl text-sm shadow-xs leading-relaxed
                                {{ $isMe ? 'bg-[#13c1ac] text-white rounded-tr-none' : 'bg-white text-gray-800 rounded-tl-none border border-gray-100' }}">
                                    {{ $message->content }}
                                </div>
                                <span class="text-[9px] text-gray-400 mt-1 px-1">
                                    {{ $message->created_at->format('H:i') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-4 border-t border-gray-200 bg-white shrink-0">
                        <form wire:submit.prevent="sendMessage" class="flex gap-2">
                            <input type="text" wire:model="newMessageContent" placeholder="Escribe un mensaje seguro..." class="flex-1 bg-gray-50 px-4 py-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:border-[#13c1ac]">
                            <button type="submit" class="bg-[#13c1ac] hover:bg-[#0fa895] text-white px-5 rounded-xl transition font-bold border-none cursor-pointer flex items-center justify-center">
                                Enviar 🚀
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex-1 flex flex-col items-center justify-center p-8 text-gray-400 bg-gray-50/30">
                        <span class="text-6xl mb-3">🎒</span>
                        <h3 class="text-base font-bold text-gray-700 mb-1">¡Bienvenido a tu bandeja de entrada!</h3>
                        <p class="text-xs max-w-xs text-center leading-relaxed">Selecciona una conversación de la izquierda para acordar el precio o el punto de entrega de tus libros en el instituto.</p>
                    </div>
                @endif
            </div>

        </div>
    @endif
</main>
