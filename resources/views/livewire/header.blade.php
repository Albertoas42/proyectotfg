<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between h-16 items-center gap-4">

            <!-- Logo -->
            <div class="flex items-center gap-2 shrink-0">
                <button wire:click="$parent.set('tab', 'catalogo')" class="text-2xl font-black text-[#13c1ac] tracking-tight bg-transparent border-none cursor-pointer">
                    💚 segundaclase
                </button>
            </div>

            <!-- Menú de Secciones para PC (Escritorio) -->
            <div class="hidden md:flex items-center space-x-1 text-sm font-medium text-gray-600">
                <button wire:click="$parent.set('tab', 'catalogo')" :class="tab === 'catalogo' ? 'text-[#13c1ac] bg-[#13c1ac]/10' : 'hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-full transition cursor-pointer">
                    🌐 Catálogo
                </button>
                <button wire:click="$parent.set('tab', 'mensajes')" :class="tab === 'mensajes' ? 'text-[#13c1ac] bg-[#13c1ac]/10' : 'hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-full transition cursor-pointer flex items-center gap-1">
                    💬 Mensajes <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.2 rounded-full">2</span>
                </button>
                <button wire:click="$parent.set('tab', 'mis-anuncios')" :class="tab === 'mis-anuncios' ? 'text-[#13c1ac] bg-[#13c1ac]/10' : 'hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-full transition cursor-pointer">
                    📦 Mis Anuncios
                </button>
                <button wire:click="$parent.set('tab', 'favoritos')" :class="tab === 'favoritos' ? 'text-[#13c1ac] bg-[#13c1ac]/10' : 'hover:bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-full transition cursor-pointer">
                    ⭐ Favoritos
                </button>
            </div>

            <!-- Acciones Usuario -->
            <div class="flex items-center gap-4 shrink-0">
                <!-- Botón "Subir producto" -->
                <a href="#" class="bg-[#13c1ac] hover:bg-[#0fa895] text-white text-sm font-bold px-4 py-2 rounded-full shadow-xs transition flex items-center gap-1">
                    <span class="text-base">+</span> <span class="hidden sm:inline">Subir Producto</span>
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-500 text-sm font-medium cursor-pointer">
                        Salir
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
