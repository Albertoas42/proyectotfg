<main class="max-w-3xl mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-black text-gray-800 tracking-tight">Subir un producto</h1>
        <p class="text-xs text-gray-400">Publica lo que ya no usas para que otros compañeros lo encuentren en el centro</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-6 md:p-8">
        <form wire:submit.prevent="saveProduct" class="space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-3">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">¿Qué vendes? (Título corto)</label>
                    <input type="text" wire:model="title" placeholder="Ej: Calculadora Casio FX, Apuntes de Redes..."
                           class="w-full bg-gray-50 p-2.5 text-sm rounded-xl border border-gray-200 focus:outline-none focus:border-[#13c1ac]">
                    @error('title') <span class="text-xs text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Precio (€)</label>
                    <input type="number" wire:model="price" placeholder="0" min="0" step="any"
                           class="w-full bg-gray-50 p-2.5 text-sm rounded-xl border border-gray-200 focus:outline-none focus:border-[#13c1ac]">
                    @error('price') <span class="text-xs text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Categoría</label>
                    <select wire:model="category_id" class="w-full bg-gray-50 p-2.5 text-sm rounded-xl border border-gray-200 focus:outline-none focus:border-[#13c1ac]">
                        <option value="">Selecciona una categoría</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-xs text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Estado del producto</label>
                    <select wire:model="item_condition" class="w-full bg-gray-50 p-2.5 text-sm rounded-xl border border-gray-200 focus:outline-none focus:border-[#13c1ac]">
                        <option value="new">✨ Nuevo / Precintado</option>
                        <option value="good">👍 Buen estado / Poco uso</option>
                        <option value="worn">📁 Usado / Desgastado</option>
                    </select>
                    @error('item_condition') <span class="text-xs text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">📍 Punto de encuentro preferido</label>
                <div class="relative">
                    <select wire:model="location" class="w-full bg-gray-50 p-2.5 text-sm rounded-xl border border-gray-200 focus:outline-none focus:border-[#13c1ac] appearance-none cursor-pointer font-medium text-gray-700">
                        <option value="Patio Central">Patio Central (Recreo)</option>
                        <option value="Biblioteca">Biblioteca del Instituto</option>
                        <option value="Cantina / Cafetería">Cantina / Cafetería</option>
                        <option value="Entrada Principal">Puerta de Entrada Principal</option>
                        <option value="Conserjería">Junto a Conserjería</option>
                        <option value="A acordar por chat">A acordar con el compañero por chat</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>
                @error('location') <span class="text-xs text-red-500 font-medium mt-1 block">⚠️ {{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Descripción del anuncio</label>
                <textarea wire:model="description" rows="5" placeholder="Detalla el estado del artículo, si lo entregas con caja, tus zonas o aulas preferidas del instituto para el intercambio..."
                          class="w-full bg-gray-50 p-2.5 text-sm rounded-xl border border-gray-200 focus:outline-none focus:border-[#13c1ac] resize-none"></textarea>
                @error('description') <span class="text-xs text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Foto del producto</label>
                <div class="flex flex-col sm:flex-row items-center gap-4 bg-gray-50 p-4 rounded-xl border border-gray-200">

                    <div class="relative w-full sm:w-auto">
                        <input type="file" wire:model="image" id="product-image" class="hidden" accept="image/*">
                        <label for="product-image" class="w-full sm:w-auto block text-center bg-white border border-gray-200 hover:border-[#13c1ac] px-4 py-2 rounded-xl text-xs font-bold text-gray-600 cursor-pointer transition shadow-xs">
                            📸 Seleccionar imagen
                        </label>
                    </div>

                    <div wire:loading wire:target="image" class="text-xs text-gray-400 font-medium animate-pulse">
                        Procesando foto... ⏳
                    </div>

                    @if ($image)
                        <div class="w-20 h-20 bg-white rounded-lg border border-gray-200 overflow-hidden relative shrink-0">
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                </div>
                @error('image') <span class="text-xs text-red-500 font-medium mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('products.index') }}" wire:navigate
                   class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-sm font-bold rounded-xl transition no-underline">
                    Cancelar
                </a>
                <button type="submit" wire:loading.attr="disabled"
                        class="px-6 py-2.5 bg-[#13c1ac] hover:bg-[#0fa895] text-white text-sm font-bold rounded-xl shadow-xs transition border-none cursor-pointer disabled:opacity-50">
                    🚀 Publicar Anuncio
                </button>
            </div>

        </form>
    </div>
</main>
