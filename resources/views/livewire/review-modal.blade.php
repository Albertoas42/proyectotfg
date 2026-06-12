<div class="{{ $isOpen ? 'fixed' : 'hidden' }} inset-0 z-50 flex items-center justify-center bg-gray-900/50">
    <div class="bg-white p-8 rounded-2xl w-full max-w-sm shadow-xl">
        <h2 class="text-xl font-black mb-4">Valora tu compra</h2>

        <label class="block text-sm font-bold mb-2">Puntuación (1-5)</label>
        <input type="number" wire:model="rating" min="1" max="5" class="w-full p-2 border rounded-lg mb-4">

        <label class="block text-sm font-bold mb-2">Comentario</label>
        <textarea wire:model="comment" class="w-full p-2 border rounded-lg mb-4"></textarea>

        <button wire:click="save" class="w-full bg-[#13c1ac] text-white font-black py-2 rounded-xl">
            Enviar Valoración
        </button>
    </div>
</div>
