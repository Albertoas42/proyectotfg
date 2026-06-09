<main class="max-w-6xl mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-black text-gray-800 tracking-tight">Mis Productos Favoritos</h1>
        <p class="text-xs text-gray-400">Anuncios que te interesan y tienes guardados</p>
    </div>

    @if($products->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-12 text-center max-w-xl mx-auto my-8">
            <div class="w-20 h-20 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center text-4xl mx-auto mb-4">
                ⭐
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">No tienes favoritos guardados</h3>
            <p class="text-sm text-gray-500 mb-8 leading-relaxed">
                Explora el catálogo del instituto y pulsa sobre el corazón de cualquier artículo para tenerlo controlado en esta pestaña.
            </p>
            <a href="{{ route('products.index') }}" wire:navigate
               class="inline-flex items-center gap-2 bg-[#13c1ac] hover:bg-[#0fa895] text-white px-6 py-3 rounded-xl font-bold transition no-underline shadow-xs">
                🌐 Ver catálogo
            </a>
        </div>

    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($products as $product)
                <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-md transition flex flex-col justify-between group relative">

                    <div class="relative bg-gray-100 aspect-square w-full flex items-center justify-center text-gray-300 shrink-0">

                        <a href="{{ route('products.show', $product->product_id) }}" wire:navigate class="absolute inset-0 z-10"></a>

                        <img src="{{ $product->image_path ?? 'https://placehold.co/600x600?text=Sin+Foto' }}"
                             alt="{{ $product->title }}"
                             class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-200">

                        <span class="absolute bottom-2 left-2 bg-black/50 text-white text-[10px] font-semibold px-2 py-0.5 rounded-md backdrop-blur-xs z-20">
                            {{ $product->category->category_name }}
                        </span>

                        <button wire:click.stop="toggleFavorite({{ $product->product_id }})"
                                class="absolute top-2 right-2 bg-white/90 hover:bg-white p-2 rounded-full shadow-md transition border-none cursor-pointer z-20 flex items-center justify-center transform active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-4 w-4 text-red-500 fill-current"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor"
                                 stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-3 flex flex-col flex-1 justify-between relative">
                        <a href="{{ route('products.show', $product->product_id) }}" wire:navigate class="absolute inset-0 z-10"></a>

                        <div class="relative z-20 pointer-events-none">
                            <div class="text-base font-extrabold text-gray-900 mb-0.5">{{ number_format($product->price, 0) }} €</div>
                            <h3 class="text-sm font-normal text-gray-700 line-clamp-2 mb-1 leading-tight group-hover:text-[#13c1ac] transition">{{ $product->title }}</h3>
                        </div>

                        <div class="mt-3 pt-2 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400 relative z-20 pointer-events-none">
                            <span class="truncate">📍 Aula / Recreo</span>
                            <span class="font-medium text-gray-500 shrink-0 flex items-center gap-1">
                                {{ $product->seller->first_name }}
                                @if($product->seller->hasRole('admin')) 🛡️ @endif
                            </span>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @endif

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
