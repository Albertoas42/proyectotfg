<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between h-16 items-center gap-4">

            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('products.index') }}" wire:navigate class="text-2xl font-black text-[#13c1ac] tracking-tight no-underline">
                    💚 Segundaclase
                </a>
            </div>

            <div class="hidden md:flex items-center space-x-1 text-sm font-medium text-gray-600">
                <a href="{{ route('products.index') }}" wire:navigate
                   class="px-4 py-2 rounded-full transition {{ request()->routeIs('products.index') ? 'text-[#13c1ac] bg-[#13c1ac]/10 font-bold' : 'hover:bg-gray-100 text-gray-600' }}">
                    🌐 Catálogo
                </a>
                <a href="{{ route('chats.inbox') }}" wire:navigate
                   class="px-4 py-2 rounded-full transition flex items-center gap-1 {{ request()->routeIs('chats.inbox') ? 'text-[#13c1ac] bg-[#13c1ac]/10 font-bold' : 'hover:bg-gray-100 text-gray-600' }}">
                    💬 Mensajes <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.2 rounded-full">2</span>
                </a>
                <a href="{{ route('my-products.index') }}" wire:navigate
                   class="px-4 py-2 rounded-full transition {{ request()->routeIs('my-products.index') ? 'text-[#13c1ac] bg-[#13c1ac]/10 font-bold' : 'hover:bg-gray-100 text-gray-600' }}">
                    📦 Mis Anuncios
                </a>
                <a href="{{ route('favorites.index') }}" wire:navigate
                   class="px-4 py-2 rounded-full transition {{ request()->routeIs('favorites.index') ? 'text-[#13c1ac] bg-[#13c1ac]/10 font-bold' : 'hover:bg-gray-100 text-gray-600' }}">
                    ⭐ Favoritos
                </a>
            </div>

            <div class="flex items-center gap-4 shrink-0">
                <a href="{{ route('products.create') }}" wire:navigate
                   class="bg-[#13c1ac] hover:bg-[#0fa895] text-white text-sm font-bold px-4 py-2 rounded-full shadow-xs transition flex items-center gap-1 no-underline shrink-0">
                    <span class="text-base">+</span>
                    <span class="hidden sm:inline">Subir Producto</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-500 text-sm font-medium cursor-pointer bg-transparent border-none">
                        Salir
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
