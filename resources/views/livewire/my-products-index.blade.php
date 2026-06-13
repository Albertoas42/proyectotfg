<main class="max-w-5xl mx-auto px-4 py-6">

    <div class="mb-6 flex sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-800 tracking-tight">Mis Anuncios</h1>
            <p class="text-xs text-gray-400">Administra los productos que has publicado en el instituto</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
            ✅ {{ session('message') }}
        </div>
    @endif

    @if($products->isEmpty())
        <div class="bg-white border border-gray-200 rounded-2xl p-12 text-center max-w-xl mx-auto my-8">
            <span class="text-5xl block mb-4">🎒</span>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Aún no has subido nada</h3>
            <p class="text-sm text-gray-400 mb-6">¿Tienes libros del año pasado o apuntes que ya no uses? Ponlos a la venta.</p>
            <a href="{{ route('products.create') }}" wire:navigate
               class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-4 py-2 rounded-xl text-xs no-underline transition">
                Empezar a vender
            </a>
        </div>
    @else
        <div class="space-y-3">
            @foreach($products as $product)
                <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-4 flex flex-col sm:flex-row items-center justify-between gap-4 hover:border-gray-300 transition relative">

                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <div class="w-16 h-16 bg-gray-100 rounded-xl overflow-hidden shrink-0 border border-gray-100 relative">
                            <img src="{{ $product->image_url ? asset($product->image_url) : 'https://placehold.co/600x600?text=Sin+Foto' }}"
                                 alt="{{ $product->title }}"
                                 class="w-full h-full object-cover {{ $product->status == 'sold' ? 'grayscale opacity-50' : '' }}">
                        </div>

                        <div class="space-y-1 min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-base font-black text-gray-900 {{ $product->status == 'sold' ? 'line-through text-gray-400' : '' }}">
                                    {{ number_format($product->price, 2) }} €
                                </span>

                                <span class="bg-gray-100 text-gray-600 text-[10px] font-semibold px-2 py-0.5 rounded-md">
                                    {{ $product->category->category_name }}
                                </span>

                                <span class="text-[10px] font-semibold px-2 py-0.5 rounded-md @if($product->item_condition == 'new') bg-emerald-50 text-emerald-700 @elseif($product->item_condition == 'good') bg-blue-50 text-blue-700 @else bg-amber-50 text-amber-700 @endif">
                                    @if($product->item_condition == 'new') ✨ Nuevo @elseif($product->item_condition == 'good') 👍 Bueno @else 📁 Usado @endif
                                </span>
                            </div>

                            <h3 class="text-sm font-bold text-gray-700 truncate max-w-xs md:max-w-md {{ $product->status == 'sold' ? 'text-gray-400 italic' : '' }}">
                                {{ $product->title }}
                            </h3>

                            <p class="text-[10px] text-gray-400">
                                Publicado el {{ $product->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 w-full sm:w-auto justify-between sm:justify-end border-t sm:border-none pt-3 sm:pt-0">

                        <div class="flex items-center gap-1 bg-gray-50 p-1 rounded-xl border border-gray-100">

                            <button wire:click="changeProductStatus('{{ $product->product_id }}', 'available')"
                                    @if(($product->status ?? 'available') == 'available') disabled @endif
                                    class="text-[10px] font-bold px-2.5 py-1.5 rounded-lg transition border-none cursor-pointer flex items-center gap-1
                                    {{ ($product->status ?? 'available') == 'available' ? 'bg-emerald-500 text-white shadow-xs' : 'bg-transparent text-gray-500 hover:bg-gray-200/60' }}">
                                🟢 Disponible
                            </button>

                            <button wire:click="changeProductStatus('{{ $product->product_id }}', 'reserved')"
                                    @if($product->status == 'reserved') disabled @endif
                                    class="text-[10px] font-bold px-2.5 py-1.5 rounded-lg transition border-none cursor-pointer flex items-center gap-1
                                    {{ $product->status == 'reserved' ? 'bg-amber-500 text-white shadow-xs' : 'bg-transparent text-gray-500 hover:bg-gray-200/60' }}">
                                ⏳ Reservar
                            </button>

                            <button wire:click="changeProductStatus('{{ $product->product_id }}', 'sold')"
                                    @if($product->status == 'sold') disabled @endif
                                    class="text-[10px] font-bold px-2.5 py-1.5 rounded-lg transition border-none cursor-pointer flex items-center gap-1
                                    {{ $product->status == 'sold' ? 'bg-gray-600 text-white shadow-xs' : 'bg-transparent text-gray-500 hover:bg-gray-200/60' }}">
                                💼 Vender
                            </button>

                        </div>

                        <div class="flex items-center gap-1">
                            <a href="{{ route('products.show', $product->product_id) }}" wire:navigate
                               class="p-2 bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-xl border border-gray-200 transition text-sm no-underline"
                               title="Ver anuncio público">
                                👁️
                            </a>

                            <x-modal-confirm
                                :id="$product->product_id"
                                method="deleteProduct"
                                title="¿Eliminar este anuncio?"
                            >
                                {{-- Todo lo que metas aquí dentro será el botón visible en la fila --}}
                                <button type="button" class="p-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl border border-red-200 transition text-sm cursor-pointer" title="Eliminar Anuncio">
                                    🗑️
                                </button>

                                <x-slot:description>
                                    Esta acción no se puede deshacer. El anuncio de <span class="font-bold text-gray-700">"{{ $product->title }}"</span> se borrará permanentemente de la plataforma del instituto.
                                </x-slot:description>
                            </x-modal-confirm>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>
    @endif
</main>
