<main class="max-w-2xl mx-auto px-4 py-6">
    <div class="mb-4">
        <a href="{{ route('products.index') }}" wire:navigate class="text-sm font-medium text-gray-500 hover:text-[#13c1ac] flex items-center gap-1 no-underline">
            ⬅️ Cancelar y volver
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-xs">
        <h2 class="text-xl font-black text-gray-800 mb-6">¿Qué vas a vender hoy? 📦</h2>

        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Título del anuncio</label>
                <input type="text" wire:model="title" placeholder="Ej: Libro Matemáticas 2º DAW"
                       class="w-full bg-gray-50 p-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:border-[#13c1ac]">
                @error('title') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Precio (€)</label>
                    <input type="number" wire:model="price" placeholder="0"
                           class="w-full bg-gray-50 p-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:border-[#13c1ac]">
                    @error('price') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Categoría</label>
                    <select wire:model="category_id" class="w-full bg-gray-50 p-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:border-[#13c1ac]">
                        <option value="">Selecciona una...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Estado del artículo</label>
                <div class="grid grid-cols-3 gap-2">
                    <label class="border p-3 rounded-xl text-sm flex items-center justify-center gap-1 cursor-pointer transition {{ $item_condition === 'new' ? 'border-[#13c1ac] bg-[#13c1ac]/5 text-[#13c1ac] font-bold' : 'bg-gray-50 text-gray-600' }}">
                        <input type="radio" wire:model="item_condition" value="new" class="hidden"> ✨ Nuevo
                    </label>
                    <label class="border p-3 rounded-xl text-sm flex items-center justify-center gap-1 cursor-pointer transition {{ $item_condition === 'good' ? 'border-[#13c1ac] bg-[#13c1ac]/5 text-[#13c1ac] font-bold' : 'bg-gray-50 text-gray-600' }}">
                        <input type="radio" wire:model="item_condition" value="good" class="hidden"> 👍 Bueno
                    </label>
                    <label class="border p-3 rounded-xl text-sm flex items-center justify-center gap-1 cursor-pointer transition {{ $item_condition === 'used' ? 'border-[#13c1ac] bg-[#13c1ac]/5 text-[#13c1ac] font-bold' : 'bg-gray-50 text-gray-600' }}">
                        <input type="radio" wire:model="item_condition" value="used" class="hidden"> 📁 Usado
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Descripción</label>
                <textarea wire:model="description" rows="4" placeholder="Describe los detalles de tu artículo, si está subrayado, etc..."
                          class="w-full bg-gray-50 p-3 text-sm rounded-xl border border-gray-200 focus:outline-none focus:border-[#13c1ac] resize-none"></textarea>
                @error('description') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3 bg-[#13c1ac] hover:bg-[#0fa895] text-white text-sm font-bold rounded-xl shadow-xs transition border-none cursor-pointer">
                    🚀 Publicar Anuncio
                </button>
            </div>
        </form>
    </div>
</main>
