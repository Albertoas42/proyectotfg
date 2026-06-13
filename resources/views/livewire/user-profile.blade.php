<main class="max-w-6xl mx-auto px-4 py-6">

    @if (session()->has('message'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-semibold shadow-xs">
            ✅ {{ session('message') }}
        </div>
    @endif

    @if (session()->has('info'))
        <div class="mb-4 bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-xl text-xs font-mono shadow-xs">
            ℹ️ {{ session('info') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-200 shadow-xs p-6 md:p-8 mb-6 relative">
        <div class="flex flex-col md:flex-row items-center md:items-start justify-between gap-6">

            <div class="flex flex-col sm:flex-row items-center text-center sm:text-left gap-4 w-full">

                <div class="relative group shrink-0">
                    <div class="w-24 h-24 bg-[#13c1ac]/10 text-[#13c1ac] font-black rounded-full flex items-center justify-center text-4xl uppercase overflow-hidden border-2 border-gray-100 shadow-xs">
                        @if($newAvatar)
                            <img src="{{ $newAvatar->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif($user->profile?->avatar_path)
                            <img src="{{ asset('storage/' . $user->profile->avatar_path) }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($user->first_name ?? 'U', 0, 1) }}
                        @endif
                    </div>

                    @if($isEditing)
                        <label class="absolute inset-0 bg-black/40 text-white text-[10px] font-bold rounded-full flex flex-col items-center justify-center cursor-pointer opacity-0 group-hover:opacity-100 transition duration-150">
                            📷 <span>Cambiar</span>
                            <input type="file" wire:model="newAvatar" class="hidden" accept="image/*">
                        </label>
                    @endif
                </div>

                <div class="w-full">
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mb-1">
                        @if($isEditing)
                            <div class="flex gap-2 w-full sm:w-auto">
                                <input type="text" wire:model="first_name" class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5 text-base font-bold text-gray-800 focus:outline-none focus:border-[#13c1ac] w-1/2">
                                <input type="text" wire:model="last_name" class="bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5 text-base font-bold text-gray-800 focus:outline-none focus:border-[#13c1ac] w-1/2">
                            </div>
                        @else
                            <h1 class="text-2xl font-black text-gray-800 tracking-tight">{{ $user->first_name }} {{ $user->last_name }}</h1>
                        @endif

                        @if($user->profile?->is_verified)
                            <span class="text-emerald-500 bg-emerald-50 border border-emerald-200 text-xs font-bold px-2 py-0.5 rounded-full flex items-center gap-1 cursor-help" title="Alumno verificado mediante cuenta del instituto">
                                Verified ✅
                            </span>
                        @endif

                        @if($user->hasRole('admin'))
                            <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider border border-red-200">Admin 🛡️</span>
                        @endif
                    </div>

                    <p class="text-sm font-semibold text-[#13c1ac] mb-2">
                        @if($isEditing)
                            <select wire:model="course" class="bg-gray-50 border border-gray-200 rounded-xl px-2 py-1 text-xs font-semibold text-gray-700 focus:outline-none focus:border-[#13c1ac] cursor-pointer mt-1">
                                <option value="">Selecciona tu clase / curso</option>
                                @foreach($availableCourses as $c)
                                    <option value="{{ $c }}">{{ $c }}</option>
                                @endforeach
                            </select>
                        @else
                            🎓 {{ $user->profile?->course ?? 'Curso no especificado' }}
                        @endif
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

            <div class="shrink-0 w-full md:w-auto flex flex-col sm:flex-row md:flex-col gap-2 justify-center">
                @if(Auth::id() === $user->user_id)
                    @if($isEditing)
                        <button wire:click="saveProfile" class="w-full bg-[#13c1ac] hover:bg-[#10a895] text-white text-xs font-bold px-4 py-2.5 rounded-xl transition border-none shadow-xs cursor-pointer">
                            Guardar Cambios
                        </button>
                        <button wire:click="toggleEdit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-500 text-xs font-bold px-4 py-2.5 rounded-xl transition border-none cursor-pointer">
                            Cancelar
                        </button>
                    @else
                        <button wire:click="toggleEdit" class="w-full bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-xs cursor-pointer flex items-center justify-center gap-1">
                            ✏️ Editar Perfil
                        </button>

                        @if(!$user->profile?->is_verified)
                            <button wire:click="sendVerificationEmail" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition border-none shadow-xs cursor-pointer flex items-center justify-center gap-1">
                                📧 Verificar Cuenta
                            </button>
                        @endif
                    @endif
                @else
                    <span class="block text-center text-xs text-gray-400 bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                        🟢 Miembro desde {{ $user->created_at->format('M Y') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-100">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Sobre mí</h3>
            @if($isEditing)
                <textarea wire:model="bio" rows="3" placeholder="Cuéntale a tus compañeros qué sueles vender, en qué pabellón estás o cuándo te viene mejor hacer los intercambios..."
                          class="w-full bg-gray-50 text-sm p-4 rounded-xl border border-gray-200 focus:outline-none focus:border-[#13c1ac] transition resize-none"></textarea>
            @else
                <p class="text-sm text-gray-600 leading-relaxed bg-gray-50/50 p-4 rounded-xl border border-gray-100/70">
                    {{ $user->profile?->bio ?? 'Este alumno aún no ha escrito una biografía descriptiva.' }}
                </p>
            @endif
        </div>
    </div>

    @if($isVerifying)
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 mb-8 text-white shadow-md flex flex-col md:flex-row items-center justify-between gap-4 animate-fade-in">
            <div class="space-y-1 text-center md:text-left">
                <h3 class="text-base font-black">Validación de Alumno en Curso</h3>
                <p class="text-xs text-emerald-100">Hemos enviado un código de seguridad simulado a tu correo institucional. Introdúcelo para conseguir tu insignia.</p>
            </div>

            <div class="flex flex-col items-end gap-1.5 w-full md:w-auto">
                <div class="flex gap-2 w-full md:w-auto">
                    <input type="text" wire:model="verificationCode" placeholder="Introduce el código de 6 dígitos"
                           class="bg-white text-gray-800 text-sm font-mono px-4 py-2.5 rounded-xl border-none focus:outline-none placeholder:text-gray-400 w-full md:w-56 text-center shadow-inner">
                    <button wire:click="checkVerificationCode" class="bg-gray-900 hover:bg-gray-800 text-white text-xs font-bold px-5 py-2.5 rounded-xl border-none transition cursor-pointer shadow-xs shrink-0">
                        Validar
                    </button>
                </div>
                @if($verificationError)
                    <span class="text-xs font-bold text-red-200 bg-red-900/30 px-3 py-1 rounded-lg w-full text-center md:text-right">{{ $verificationError }}</span>
                @endif
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-lg font-black text-gray-800 tracking-tight flex items-center gap-2">
                📦 Productos en venta <span class="bg-gray-100 text-gray-500 text-xs font-bold px-2 py-0.5 rounded-full">{{ $products->count() }}</span>
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

                @if($products->count() >= 3)
                    <div class="text-center mt-2">
                        <a href="{{ route('user.products', $user->user_id) }}" class="text-xs font-bold text-[#13c1ac] hover:text-[#0fa895] transition">
                            Ver todos los productos →
                        </a>
                    </div>
                @endif
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
