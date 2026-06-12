<div>
    {{-- Solo mostramos el modal si isOpen es true --}}
    @if($isOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" wire:click="$set('isOpen', false)"></div>

            <div class="relative bg-white p-6 rounded-3xl w-full max-w-sm shadow-2xl border border-gray-100 animate-in fade-in zoom-in duration-200">

                <div class="flex items-center gap-3 mb-5 text-red-600">
                    <span class="text-2xl">🚩</span>
                    <h2 class="text-lg font-black text-gray-900">Reportar anuncio</h2>
                </div>

                <p class="text-sm text-gray-500 mb-6">
                    Ayúdanos a mantener la comunidad segura. ¿Cuál es el motivo de tu reporte?
                </p>

                <div class="mb-6">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Motivo del reporte</label>
                    <select wire:model="reason" class="w-full p-3 bg-gray-50 rounded-xl border border-gray-200 text-sm focus:border-[#13c1ac] focus:ring-1 focus:ring-[#13c1ac] transition outline-none cursor-pointer">
                        <option value="Contenido inapropiado">Contenido inapropiado</option>
                        <option value="Producto ya vendido">Producto ya vendido</option>
                        <option value="Información engañosa">Información engañosa</option>
                        <option value="Spam o publicidad">Spam o publicidad</option>
                        <option value="Otro">Otro motivo</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button wire:click="$set('isOpen', false)"
                            class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-bold rounded-xl transition cursor-pointer border-none">
                        Cancelar
                    </button>
                    <button wire:click="save"
                            class="flex-1 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl shadow-md transition cursor-pointer border-none">
                        Enviar reporte
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
