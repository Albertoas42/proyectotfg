<main class="max-w-6xl mx-auto px-4 py-6">

    <div class="mb-6 max-w-xl mx-auto">
        <div class="flex items-center relative">
            <input type="text" wire:model.live="search" placeholder="¿Qué buscas hoy? Libros, apuntes, calculadoras..."
                   class="w-full bg-white text-sm pl-4 pr-12 py-3 rounded-full border border-gray-200 shadow-xs focus:outline-none focus:border-[#13c1ac] transition">
            <button class="absolute right-4 text-gray-400 bg-transparent border-none">🔍</button>
        </div>
    </div>

    @if($products->isEmpty())
        <div class="text-center py-16 bg-white rounded-xl border border-gray-200 shadow-xs">
            <span class="text-5xl">🧐</span>
            <p class="mt-4 text-gray-500 font-medium">No hemos encontrado nada que coincida.</p>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($products as $product)
                <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-md transition flex flex-col justify-between group cursor-pointer">

                    <div class="relative bg-gray-100 aspect-square w-full flex items-center justify-center text-gray-300 shrink-0">
                        <span class="text-5xl group-hover:scale-105 transition duration-200">📚</span>
                        <span class="absolute bottom-2 left-2 bg-black/50 text-white text-[10px] font-semibold px-2 py-0.5 rounded-md backdrop-blur-xs">
                            {{ $product->category->category_name }}
                        </span>
                        <button class="absolute top-2 right-2 bg-white/80 hover:bg-white text-gray-400 hover:text-red-500 p-1.5 rounded-full shadow-xs transition border-none cursor-pointer">❤️</button>
                    </div>

                    <div class="p-3 flex flex-col flex-1 justify-between">
                        <div>
                            <div class="text-base font-extrabold text-gray-900 mb-0.5">{{ number_format($product->price, 0) }} €</div>
                            <h3 class="text-sm font-normal text-gray-700 line-clamp-2 mb-1 group-hover:text-[#13c1ac] transition leading-tight">{{ $product->title }}</h3>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400">
                            <span class="truncate">📍 Aula / Recreo</span>
                            <span class="font-medium text-gray-500 shrink-0">{{ $product->seller->first_name }}</span>
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
        <a href="{{ route('messages.index') }}" wire:navigate class="flex flex-col items-center gap-0.5 no-underline {{ request()->routeIs('messages.index') ? 'text-[#13c1ac]' : 'text-gray-400' }}">
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
