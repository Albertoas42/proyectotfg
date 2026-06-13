<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto ">
        <div class="flex justify-between h-16 items-center gap-2">

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
                    💬 Mensajes

                    <div wire:key="header-unread-count-{{ $unreadCount ?? 0 }}" class="inline-flex items-center">
                        @if(isset($unreadCount) && $unreadCount > 0)
                            <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold animate-pulse">
                                {{ $unreadCount }}
                            </span>
                        @endif
                    </div>
                </a>

                <a href="{{ route('my-products.index') }}" wire:navigate
                   class="px-4 py-2 rounded-full transition {{ request()->routeIs('my-products.index') ? 'text-[#13c1ac] bg-[#13c1ac]/10 font-bold' : 'hover:bg-gray-100 text-gray-600' }}">
                    📦 Mis Anuncios
                </a>
                <a href="{{ route('favorites.index') }}" wire:navigate
                   class="px-4 py-2 rounded-full transition {{ request()->routeIs('favorites.index') ? 'text-[#13c1ac] bg-[#13c1ac]/10 font-bold' : 'hover:bg-gray-100 text-gray-600' }}">
                    ⭐ Favoritos
                </a>
                @can('moderar productos')
                    <a href="{{ route('admin.reports') }}" wire:navigate
                       class="px-4 py-2 rounded-full transition flex items-center gap-1 {{ request()->routeIs('admin.reports') ? 'text-red-700 bg-red-50 font-bold' : 'hover:bg-red-50 text-red-600' }}">
                        🚩 Moderación
                    </a>
                @endcan
            </div>

            <div class="flex items-center gap-4 shrink-0">
                @auth
                    @if(Auth::user()->profile && Auth::user()->profile->is_verified)
                        <a href="{{ route('products.create') }}" wire:navigate
                           class="bg-[#13c1ac] hover:bg-[#0fa895] text-white text-sm font-bold px-4 py-2 rounded-full shadow-xs transition flex items-center gap-1 no-underline shrink-0">
                            <span class="text-base">+</span>
                            <span class="hidden sm:inline">Subir Producto</span>
                        </a>
                    @else
                        <button @click="$dispatch('open-verification-modal')"
                                class="bg-gray-300 text-white text-sm font-bold px-4 py-2 rounded-full cursor-pointer flex items-center gap-1 border-none shadow-xs">
                            <span class="text-base">+</span>
                            <span class="hidden sm:inline">Subir Producto</span>
                        </button>
                    @endif

                    <a href="{{ route('user.profile', Auth::id()) }}" wire:navigate
                       class="flex items-center gap-2 px-3 py-1.5 hover:bg-gray-100 rounded-full transition no-underline text-gray-700">
                        <div class="w-7 h-7 bg-[#13c1ac]/10 text-[#13c1ac] text-xs font-black rounded-full flex items-center justify-center uppercase">
                            {{ substr(Auth::user()->first_name ?? 'U', 0, 1) }}
                        </div>
                        <span class="text-sm font-semibold hidden sm:inline">{{ Auth::user()->first_name }}</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 text-sm font-medium cursor-pointer bg-transparent border-none">
                            Salir
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>
    <div x-data="{ showModal: false }"
         @open-verification-modal.window="showModal = true"
         x-show="showModal"
         class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-cloak>

        <div @click.away="showModal = false" class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl">
            <div class="text-center mb-4">
                <div class="text-4xl">🛡️</div>
            </div>
            <h3 class="text-lg font-black text-gray-800 mb-2">¡Casi estás listo!</h3>
            <p class="text-sm text-gray-500 mb-6">Para mantener la seguridad en nuestra comunidad, necesitas estar verificado antes de poder publicar anuncios.</p>

            <div class="flex flex-col gap-2">
                <a href="{{ route('user.profile', Auth::id()) }}"
                   class="w-full py-2 bg-[#13c1ac] hover:bg-[#0fa895] text-white text-center font-bold rounded-xl transition">
                    Verificar perfil
                </a>
                <button @click="showModal = false"
                        class="w-full py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</nav>
