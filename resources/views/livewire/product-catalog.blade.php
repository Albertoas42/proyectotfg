<main class="max-w-7xl mx-auto px-4 py-6">

    <div class="mb-8 max-w-2xl mx-auto">
        <div class="flex items-center relative">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="¿Qué buscas hoy? Libros, apuntes, calculadoras..."
                   class="w-full bg-white text-sm pl-4 pr-12 py-3 rounded-full border border-gray-200 shadow-xs focus:outline-none focus:border-[#13c1ac] transition">
            <button class="absolute right-4 text-gray-400 bg-transparent border-none">🔍</button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">

        <aside class="bg-white rounded-2xl border border-gray-200 p-5 space-y-6 lg:sticky lg:top-4 shadow-xs">

            <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                <h2 class="text-sm font-black text-gray-800 uppercase tracking-wider">Filtros</h2>

                @if($search || $selectedCategory || $selectedCondition)
                    <button wire:click="$set('search', ''); $set('selectedCategory', ''); $set('selectedCondition', '')"
                            class="text-[11px] font-bold text-red-500 hover:underline transition cursor-pointer bg-transparent border-none">
                        Limpiar
                    </button>
                @endif
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Categoría</label>
                <div class="relative">
                    <select wire:model.live="selectedCategory"
                            class="w-full bg-gray-50 px-3 py-2.5 text-xs font-semibold rounded-xl border border-gray-200 text-gray-700 focus:outline-none focus:border-[#13c1ac] cursor-pointer appearance-none">
                        <option value="">📁 Todas las categorías</option>
                        @foreach(\App\Models\Category::all() as $category)
                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Estado del artículo</label>
                <div class="relative">
                    <select wire:model.live="selectedCondition"
                            class="w-full bg-gray-50 px-3 py-2.5 text-xs font-semibold rounded-xl border border-gray-200 text-gray-700 focus:outline-none focus:border-[#13c1ac] cursor-pointer appearance-none">
                        <option value="">✨ Cualquier estado</option>
                        <option value="new">✨ Nuevo / Precintado</option>
                        <option value="good">👍 Buen estado</option>
                        <option value="worn">📁 Usado / Desgastado</option>
                    </select>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-100 hidden lg:block">
                <span class="text-[10px] font-medium text-gray-400 block">📍 Intercambios en mano dentro del centro escolar.</span>
            </div>

        </aside>

        <div class="lg:col-span-3">

            @if($products->isEmpty())
                <div class="text-center py-16 bg-white rounded-2xl border border-gray-200 shadow-xs">
                    <span class="text-5xl">🧐</span>
                    <p class="mt-4 text-gray-500 font-medium">No hemos encontrado ningún producto con esos filtros.</p>
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-3 gap-4">
                    @foreach($products as $product)
                        <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-md transition flex flex-col justify-between group relative">

                            <div class="relative bg-gray-100 aspect-square w-full flex items-center justify-center text-gray-300 shrink-0">
                                <a href="{{ route('products.show', $product->product_id) }}" wire:navigate class="absolute inset-0 z-10"></a>

                                <img src="{{ $product->image_url ? asset($product->image_url) : 'https://placehold.co/600x600?text=Sin+Foto' }}"
                                     alt="{{ $product->title }}"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-200 {{ $product->status == 'sold' ? 'grayscale opacity-60' : '' }}">

                                <span class="absolute bottom-2 left-2 bg-black/50 text-white text-[10px] font-semibold px-2 py-0.5 rounded-md backdrop-blur-xs z-20">
                                    {{ $product->category->category_name }}
                                </span>

                                <div class="absolute top-2 right-2 z-20">
                                    @if($product->status == 'reserved')
                                        <span class="bg-amber-500 text-white text-[9px] font-black px-2 py-1 rounded-md shadow-xs uppercase tracking-wider">
                                            ⏳ Reservado
                                        </span>
                                    @elseif($product->status == 'sold')
                                        <span class="bg-gray-600 text-white text-[9px] font-black px-2 py-1 rounded-md shadow-xs uppercase tracking-wider">
                                            💼 Vendido
                                        </span>
                                    @else
                                        <span class="bg-emerald-500 text-white text-[9px] font-black px-2 py-1 rounded-md shadow-xs uppercase tracking-wider">
                                            🟢 Disponible
                                        </span>
                                    @endif
                                </div>

                                @unless(Auth::user()->hasRole('admin'))
                                    @php $isFavorite = $product->isFavoritedBy(Auth::user()); @endphp
                                    <button wire:click.stop="toggleFavorite({{ $product->product_id }})"
                                            class="absolute top-2 left-2 bg-white/90 hover:bg-white p-2 rounded-full shadow-md transition border-none cursor-pointer z-20 flex items-center justify-center transform active:scale-95 group/heart">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-colors duration-200 {{ $isFavorite ? 'text-red-500 fill-current' : 'text-gray-400 group-hover/heart:text-red-400' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                @endunless

                                @hasrole('admin')
                                <div class="absolute top-2 left-2 flex gap-1.5 z-30" onclick="event.stopPropagation();">
                                    <a href="{{ route('products.show', [$product->product_id, 'editar']) }}" wire:navigate
                                       class="bg-amber-500 hover:bg-amber-600 text-white p-1.5 rounded-lg shadow-md transition no-underline text-xs flex items-center justify-center w-7 h-7" title="Editar Anuncio">
                                        ✏️
                                    </a>
                                    <button type="button" wire:click.stop="deleteProduct('{{ $product->product_id }}')" wire:confirm="¿Seguro que quieres borrar este producto como administrador?"
                                            class="bg-red-500 hover:bg-red-600 text-white p-1.5 rounded-lg shadow-md transition border-none cursor-pointer text-xs flex items-center justify-center w-7 h-7" title="Eliminar">
                                        🗑️
                                    </button>
                                </div>
                                @endhasrole
                            </div>

                            <div class="p-3 flex flex-col flex-1 justify-between relative">
                                <a href="{{ route('products.show', $product->product_id) }}" wire:navigate class="absolute inset-0 z-10"></a>

                                <div class="relative z-20 pointer-events-none">
                                    <div class="text-base font-extrabold text-gray-900 mb-0.5 {{ $product->status == 'sold' ? 'line-through text-gray-400' : '' }}">
                                        {{ number_format($product->price, 0) }} €
                                    </div>
                                    <h3 class="text-sm font-normal text-gray-700 line-clamp-2 mb-1 leading-tight group-hover:text-[#13c1ac] transition {{ $product->status == 'sold' ? 'text-gray-400 italic' : '' }}">
                                        {{ $product->title }}
                                    </h3>
                                </div>

                                <div class="mt-3 pt-2 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400 relative z-20">
                                    <span class="truncate pointer-events-none">📍 Aula / Recreo</span>
                                    <a href="{{ route('user.profile', $product->seller_id) }}" wire:navigate
                                       class="font-medium text-gray-500 shrink-0 flex items-center gap-1 hover:text-[#13c1ac] no-underline transition relative z-30 pointer-events-auto">
                                        {{ $product->seller->first_name }}
                                        @if($product->seller->hasRole('admin')) 🛡️ @endif
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>

                <div class="mt-8 pt-4 border-t border-gray-100">
                    {{ $products->links() }}
                </div>

            @endif

        </div>
    </div>

    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg flex justify-around py-2 z-50">
        <a href="{{ route('products.index') }}" wire:navigate class="flex flex-col items-center gap-0.5 no-underline {{ request()->routeIs('products.index') ? 'text-[#13c1ac]' : 'text-gray-400' }}">
            <span class="text-xl">🌐</span><span class="text-[10px] font-semibold">Catálogo</span>
        </a>
        <a href="{{ route('chats.inbox') }}" wire:navigate class="flex flex-col items-center gap-0.5 no-underline {{ request()->routeIs('chats.inbox') ? 'text-[#13c1ac]' : 'text-gray-400' }}">
            <span class="text-xl">💬</span><span class="text-[10px] font-semibold">Mensajes</span>
        </a>
        <a href="{{ route('my-products.index') }}" wire:navigate class="flex flex-col items-center gap-0.5 no-underline {{ request()->routeIs('my-products.index') ? 'text-[#13c1ac]' : 'text-gray-400' }}">
            <span class="text-xl">📦</span><span class="text-[10px] font-semibold">Anuncios</span>
        </a>
        <a href="{{ route('favorites.index') }}" wire:navigate class="flex flex-col items-center gap-0.5 no-underline {{ request()->routeIs('favorites.index') ? 'text-[#13c1ac]' : 'text-gray-400' }}">
            <span class="text-xl">⭐</span><span class="text-[10px] font-semibold">Favoritos</span>
        </a>
    </div>

</main>
