@props([
    'id',
    'method',
    'title' => '¿Estás seguro?',
    'buttonText' => 'Sí, eliminar'
])

<div x-data="{ openModal: false }" class="inline-block">
    <div @click="openModal = true">
        {{ $slot }}
    </div>

    <template x-teleport="body">
        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>

            <div x-show="openModal" x-transition.opacity class="fixed inset-0 bg-gray-900/60 backdrop-blur-xs"></div>

            <div x-show="openModal" x-transition.scale.95 @click.away="openModal = false" class="bg-white rounded-2xl max-w-sm w-full p-6 shadow-2xl border border-gray-100 z-10 text-center relative">

                <div class="w-10 h-10 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-xl mx-auto mb-3">
                    🗑️
                </div>

                <h3 class="text-base font-black text-gray-800 mb-1">{{ $title }}</h3>
                <p class="text-xs text-gray-500 max-w-xs mx-auto leading-relaxed mb-5">
                    {{ $description ?? 'Esta acción no se puede deshacer y el registro se eliminará permanentemente.' }}
                </p>

                <div class="flex gap-2.5 justify-center">
                    <button @click="openModal = false" type="button" class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-black rounded-xl uppercase tracking-wider border-none cursor-pointer transition">
                        Cancelar
                    </button>

                    {{-- Ejecuta dinámicamente el método que le pasemos por parámetro --}}
                    <button wire:click="{{ $method }}({{ $id }})" @click="openModal = false" type="button" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white text-xs font-black rounded-xl uppercase tracking-wider border-none cursor-pointer transition shadow-md shadow-red-500/20">
                        {{ $buttonText }}
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
