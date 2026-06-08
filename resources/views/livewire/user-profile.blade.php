<main class="max-w-5xl mx-auto px-4 py-8">

    <div class="bg-white rounded-3xl border border-gray-200 shadow-xs p-6 md:p-10 mb-8">
        <div class="flex flex-col md:flex-row items-center gap-6">

            <div class="relative">
                <div class="w-32 h-32 bg-[#13c1ac]/10 text-[#13c1ac] rounded-full flex items-center justify-center text-4xl font-black border-4 border-white shadow-md">
                    {{ substr($user->first_name, 0, 1) }}
                </div>
                @if($user->profile && $user->profile->is_verified)
                    <div class="absolute bottom-1 right-1 bg-blue-500 text-white p-1.5 rounded-full border-4 border-white" title="Cuenta Verificada">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293l-4 4a1 1 0 01-1.414 0l-2-2a1 1 0 111.414-1.414L9 10.586l3.293-3.293a1 1 0 111.414 1.414z"></path></svg>
                    </div>
                @endif
            </div>

            <div class="text-center md:text-left flex-1">
                <h1 class="text-3xl font-black text-gray-900 flex items-center justify-center md:justify-start gap-2">
                    {{ $user->first_name }} {{ $user->last_name }}
                </h1>

                <p class="text-gray-500 font-medium mb-3">
                    {{ $user->profile->course ?? 'Estudiante del centro' }}
                </p>

                <div class="flex items-center justify-center md:justify-start gap-2 mb-4">
                    <div class="flex text-amber-400">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($averageRating) ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <span class="text-sm font-bold text-gray-700">({{ number_format($averageRating, 1) }})</span>
                    <span class="text-sm text-gray-400 font-medium">• {{ $totalReviews }} valoraciones</span>
                </div>

                <p class="text-gray-600 text-sm max-w-2xl leading-relaxed">
                    {{ $user->profile->bio ?? 'Este usuario aún no ha escrito una biografía.' }}
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4 w-full md:w-auto">
                <div class="bg-gray-50 p-4 rounded-2xl text-center border border-gray-100">
                    <div class="text-xl font-black text-gray-900">{{ $products->count() }}</div>
                    <div class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">En venta</div>
                </div>
                <div class="bg-gray-50 p-4 rounded-2xl text-center border border-gray-100">
                    <div class="text-xl font-black text-gray-900">{{ $user->reviewsWritten->count() }}</div>
                    <div class="text-[10px] uppercase font-bold text-gray-400 tracking-wider">Votos dados</div>
                </div>
            </div>
        </div>
    </div>

    <h2 class="text-xl font-black text-gray-800 mb-6 flex items-center gap-2">
        📦 Productos de {{ $user->first_name }}
    </h2>

    @if($products->isEmpty())
        <div class="bg-white rounded-2xl p-12 text-center border border-dashed border-gray-300">
            <p class="text-gray-400 font-medium">Este vendedor no tiene productos activos ahora mismo.</p>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product->product_id) }}" wire:navigate class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-md transition flex flex-col no-underline text-current">
                    <div class="relative bg-gray-100 aspect-square flex items-center justify-center text-gray-300">
                        <span class="text-4xl">📚</span>
                    </div>
                    <div class="p-3">
                        <div class="text-base font-extrabold text-gray-900">{{ number_format($product->price, 0) }} €</div>
                        <h3 class="text-xs text-gray-600 line-clamp-1">{{ $product->title }}</h3>
                    </div>
                </a>
            @endforeach
        </div>
    @endif

</main>
