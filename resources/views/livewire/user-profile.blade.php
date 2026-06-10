<main class="max-w-6xl mx-auto px-4 py-6">

    <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-6 md:p-8 mb-8">
        <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-6">

            <div class="flex flex-col sm:flex-row items-center text-center sm:text-left gap-4">
                <div class="w-20 h-20 bg-[#13c1ac]/10 text-[#13c1ac] font-black rounded-full flex items-center justify-center text-3xl uppercase shrink-0">
                    {{ substr($user->first_name ?? 'U', 0, 1) }}
                </div>

                <div>
                    <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
                        <h1 class="text-2xl font-black text-gray-800 tracking-tight">{{ $user->first_name }} {{ $user->last_name }}</h1>
                        @if($user->profile?->is_verified)
                            <span class="text-sm" title="Alumno Verificado">✅</span>
                        @endif
                        @if($user->hasRole('admin'))
                            <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider border border-red-200">Admin 🛡️</span>
                        @endif
                    </div>

                    <p class="text-sm font-semibold text-[#13c1ac] mb-2">
                        🎓 {{ $user->profile?->course ?? 'Alumno del centro' }}
                    </p>

                    <div class="flex items-center justify-center sm:justify-start gap-1.5 text-sm">
                        <div class="flex text-amber-400">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= round($averageRating))
                                    ⭐
                                @else
                                    <span class="opacity-30 grayscale">⭐</span>
                                @endif
                            @endfor
                        </div>
                        <span class="font-bold text-gray-700 ml-1">{{ number_format($averageRating, 1) }}</span>
                        <span class="text-gray-400 text-xs">({{ $totalReviews }} {{ $totalReviews == 1 ? 'reseña' : 'reseñas' }})</span>
                    </div>
                </div>
            </div>

            @if(Auth::id() !== $user->user_id)
                <div class="shrink-0 w-full md:w-auto">
                    <span class="block text-center text-xs text-gray-400 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                        🟢 Miembro desde {{ $user->created_at->format('M Y') }}
                    </span>
                </div>
            @endif
        </div>

        @if($user->profile?->bio)
            <div class="mt-6 pt-6 border-t border-gray-100">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Sobre mí</h3>
                <p class="text-sm text-gray-600 leading-relaxed bg-gray-50/50 p-4 rounded-xl border border-gray-100/70">
                    {{ $user->profile->bio }}
                </p>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-lg font-black text-gray-800 tracking-tight flex items-center gap-2">
                📦 Productos en venta <span class="bg-gray-100 text-gray-500 text-xs font-bold px-2 py-0.5 rounded-full">{{ count($products) }}</span>
            </h2>

            @if($products->isEmpty())
                <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center text-gray-400 text-sm">
                    <span class="text-3xl block mb-2">🎒</span>
                    Este alumno no tiene ningún producto disponible en este momento.
                </div>
            @else
                <div class="grid grid-cols-2 gap-4">
                    @foreach($products as $product)
                        <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-md transition flex flex-col justify-between group relative">

                            <div class="relative bg-gray-100 aspect-square w-full flex items-center justify-center text-gray-300 shrink-0">
                                <a href="{{ route('products.show', $product->product_id) }}" wire:navigate class="absolute inset-0 z-10"></a>
                                <img src="{{ $product->image_path ?? 'https://placehold.co/600x600?text=Sin+Foto' }}" alt="{{ $product->title }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-200">
                                <span class="absolute bottom-2 left-2 bg-black/50 text-white text-[10px] font-semibold px-2 py-0.5 rounded-md backdrop-blur-xs z-20">
                                    {{ $product->category->category_name }}
                                </span>
                            </div>

                            <div class="p-3 flex flex-col flex-1 justify-between relative">
                                <a href="{{ route('products.show', $product->product_id) }}" wire:navigate class="absolute inset-0 z-10"></a>
                                <div class="relative z-20 pointer-events-none">
                                    <div class="text-base font-extrabold text-gray-900 mb-0.5">{{ number_format($product->price, 0) }} €</div>
                                    <h3 class="text-sm font-normal text-gray-700 line-clamp-2 leading-tight group-hover:text-[#13c1ac] transition">{{ $product->title }}</h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="space-y-4">
            <h2 class="text-lg font-black text-gray-800 tracking-tight flex items-center gap-2">
                💬 Reseñas de compañeros <span class="bg-gray-100 text-gray-500 text-xs font-bold px-2 py-0.5 rounded-full">{{ $totalReviews }}</span>
            </h2>

            @if($user->reviewsReceived->isEmpty())
                <div class="bg-white border border-gray-200 rounded-2xl p-8 text-center text-gray-400 text-sm">
                    <span class="text-3xl block mb-2">🤝</span>
                    Aún no ha recibido valoraciones de intercambios.
                </div>
            @else
                <div class="space-y-3">
                    @foreach($user->reviewsReceived as $review)
                        <div class="bg-white border border-gray-200 p-4 rounded-xl shadow-xs">
                            <div class="flex justify-between items-start mb-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 bg-gray-100 text-gray-600 text-xs font-bold rounded-full flex items-center justify-center uppercase">
                                        {{ substr($review->reviewer->first_name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-gray-800">{{ $review->reviewer->first_name }}</h4>
                                        <p class="text-[9px] text-gray-400">{{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                <div class="text-[10px]">
                                    @for ($i = 1; $i <= 5; $i++)
                                        {{ $i <= $review->rating ? '⭐' : '☆' }}
                                    @endfor
                                </div>
                            </div>
                            <p class="text-xs text-gray-600 italic leading-relaxed">
                                "{{ $review->comment }}"
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</main>
