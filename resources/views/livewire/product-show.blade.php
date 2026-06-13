<main class="max-w-5xl mx-auto px-4 py-6">
    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
            {{ session('message') }}
        </div>
    @endif

    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('products.index') }}" wire:navigate class="text-sm font-medium text-gray-500 hover:text-[#13c1ac] flex items-center gap-1 no-underline">
            ⬅️ Volver al catálogo
        </a>

        @if(Auth::user()->user_id === $product->seller_id || Gate::allows('manage-all-products'))
            <div class="flex gap-2">
                @if(!$isEditing)
                    <button wire:click="loadEditData" class="px-4 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-lg transition cursor-pointer border-none">
                        ✏️ Editar Anuncio
                    </button>
                    <button wire:click="$dispatch('open-delete-modal')"
                            class="px-4 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg transition cursor-pointer border-none">
                        🗑️ Eliminar
                    </button>
                @else
                    <button wire:click="$set('isEditing', false)" class="px-4 py-1.5 bg-gray-400 hover:bg-gray-500 text-white text-xs font-bold rounded-lg transition cursor-pointer border-none">
                        Cancelar
                    </button>
                @endif
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white p-4 md:p-6 rounded-2xl border border-gray-200 shadow-xs">

        <div class="bg-gray-100 aspect-square rounded-xl flex items-center justify-center text-gray-300 relative overflow-hidden">
            <img src="{{ $product->image_url ? asset($product->image_url) : 'https://placehold.co/600x600?text=Sin+Foto' }}"
                 alt="{{ $product->title }}"
                 class="w-full h-full object-cover {{ $product->status == 'sold' ? 'grayscale opacity-60' : '' }}">
            <span class="absolute bottom-4 left-4 bg-black/60 text-white text-xs font-semibold px-3 py-1 rounded-full backdrop-blur-xs z-20">
                {{ $product->category->category_name }}
            </span>
        </div>

        <div class="flex flex-col justify-between">
            @if($isEditing)
                <form wire:submit.prevent="updateProduct" class="space-y-4">
                    <h3 class="text-xl font-black text-gray-800">Editar información</h3>

                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Título</label>
                        <input type="text" wire:model="editTitle" class="w-full px-4 py-2 border border-gray-200 rounded-xl mt-1 focus:border-[#13c1ac] focus:ring-1 focus:ring-[#13c1ac] outline-none">
                        @error('editTitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Descripción</label>
                        <textarea wire:model="editDescription" rows="4" class="w-full px-4 py-2 border border-gray-200 rounded-xl mt-1 focus:border-[#13c1ac] focus:ring-1 focus:ring-[#13c1ac] outline-none"></textarea>
                        @error('editDescription') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Precio (€)</label>
                        <input type="number" step="0.01" wire:model="editPrice" class="w-full px-4 py-2 border border-gray-200 rounded-xl mt-1 focus:border-[#13c1ac] focus:ring-1 focus:ring-[#13c1ac] outline-none">
                        @error('editPrice') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Ubicación</label>
                        <input type="text" wire:model="editLocation" class="w-full px-4 py-2 border border-gray-200 rounded-xl mt-1 focus:border-[#13c1ac] focus:ring-1 focus:ring-[#13c1ac] outline-none">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase">Cambiar Imagen</label>
                        <input type="file" wire:model="editImage" class="w-full mt-1 text-sm">
                    </div>

                    <button type="submit" class="w-full py-3 bg-[#13c1ac] hover:bg-[#0fa895] text-white font-black rounded-xl transition cursor-pointer border-none">
                        Guardar Cambios
                    </button>
                </form>
            @else
                <div>
                    <div class="text-3xl font-black text-gray-900 mb-2 {{ $product->status == 'sold' ? 'line-through text-gray-400' : '' }}">
                        {{ number_format($product->price, 2) }} €
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-3 leading-tight {{ $product->status == 'sold' ? 'text-gray-400 italic' : '' }}">
                        {{ $product->title }}
                    </h1>

                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="text-xs font-semibold uppercase px-2.5 py-1 rounded-md bg-gray-100 text-gray-600">
                            @if($product->item_condition == 'new') ✨ Nuevo @elseif($product->item_condition == 'good') 👍 Bueno @else 📁 Usado @endif
                        </span>
                        <span class="text-xs font-semibold uppercase px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 flex items-center gap-1">
                            📍 {{ $product->location ?? 'Por acordar' }}
                        </span>
                        @if(Gate::allows('manage-all-products'))
                            <span class="text-xs font-bold uppercase px-2.5 py-1 rounded-md bg-red-100 text-red-700 animate-pulse">🛡️ Modo Admin</span>
                        @endif
                    </div>

                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Descripción</h3>
                    <p class="text-gray-600 text-sm whitespace-pre-line leading-relaxed">{{ $product->description }}</p>
                </div>

                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 mt-6">
                    <a href="{{ route('user.profile', $product->seller_id) }}" wire:navigate class="flex items-center gap-3 mb-4 no-underline block">
                        <div class="w-10 h-10 bg-[#13c1ac]/20 text-[#13c1ac] font-bold rounded-full flex items-center justify-center text-sm">
                            {{ substr($product->seller->first_name, 0, 1) }}
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800">{{ $product->seller->first_name }} {{ $product->seller->last_name }}</h4>
                        </div>
                    </a>

                    @if($product->seller_id != Auth::user()->user_id)
                        @if($product->status == 'sold')
                            <button disabled class="w-full py-3 bg-gray-300 text-gray-500 text-sm font-bold rounded-xl border-none cursor-not-allowed">🚫 Producto vendido</button>
                        @else
                            <button wire:click="startChat" class="w-full py-3 bg-[#13c1ac] hover:bg-[#0fa895] text-white text-sm font-bold rounded-xl cursor-pointer border-none">💬 Chatear / Reservar</button>
                        @endif
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div x-data="{ showModal: false }"
         @open-delete-modal.window="showModal = true"
         x-show="showModal"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-cloak>
        <div @click.away="showModal = false" class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl">
            <h3 class="text-lg font-black text-gray-800 mb-2">¿Eliminar anuncio?</h3>
            <p class="text-sm text-gray-500 mb-6">Esta acción es irreversible. ¿Seguro que quieres borrar este producto?</p>
            <div class="flex gap-3">
                <button @click="showModal = false" class="flex-1 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition">No, cancelar</button>
                <button wire:click="deleteProduct" class="flex-1 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition">Sí, borrar</button>
            </div>
        </div>
    </div>
</main>
