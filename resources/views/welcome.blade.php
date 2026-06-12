<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SegundaClase | Mercado de alumnos</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        .bg-primary { background-color: #13c1ac; }
        .text-primary { color: #13c1ac; }
        .hover-bg-primary:hover { background-color: #0fa895; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex-shrink-0 flex items-center">
                <span class="text-xl font-black text-[#13c1ac] tracking-tight">💚 SegundaClase</span>
            </div>
            <div class="flex space-x-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/productos') }}" class="text-xs font-bold text-gray-700 hover:text-[#13c1ac] bg-gray-100 px-4 py-2 rounded-xl transition">Ir al panel</a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-bold text-gray-500 hover:text-[#13c1ac] px-3 py-2 transition">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-xs font-black text-white bg-[#13c1ac] hover:bg-[#0fa895] px-4 py-2 rounded-xl shadow-xs transition">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>

<header class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24 flex flex-col lg:flex-row items-center justify-between gap-12">
        <div class="max-w-xl text-center lg:text-left">
            <h1 class="text-4xl sm:text-5xl font-black text-gray-800 tracking-tight leading-tight mb-6">
                Dale una segunda vida a tu <span class="text-[#13c1ac]">material escolar</span>
            </h1>
            <p class="text-base text-gray-500 mb-8 leading-relaxed">
                La plataforma exclusiva para alumnos y profesores de nuestro instituto. Vende los libros que ya no usas, encuentra apuntes y recógelo en mano durante el recreo. ¡Sostenible y entre compañeros!
            </p>
            <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                @auth
                    <a href="{{ url('/productos') }}" class="inline-flex justify-center items-center px-6 py-3 text-sm font-black rounded-xl text-white bg-[#13c1ac] hover:bg-[#0fa895] shadow-xs transition">
                        Explorar el Catálogo
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-6 py-3 text-sm font-black rounded-xl text-white bg-[#13c1ac] hover:bg-[#0fa895] shadow-xs transition">
                        Empezar ahora
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-6 py-3 text-sm font-bold rounded-xl text-gray-600 bg-gray-100 hover:bg-gray-200 transition">
                        Ya tengo cuenta
                    </a>
                @endauth
            </div>
        </div>

        <div class="w-full max-w-sm bg-white p-4 rounded-3xl border border-gray-100 shadow-xl shadow-gray-100">
            <div class="bg-gray-100 h-40 rounded-2xl mb-4 flex items-center justify-center text-gray-300 font-bold">
                📷 Vista previa
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="bg-[#13c1ac]/10 text-[#13c1ac] text-[10px] font-black px-2 py-0.5 rounded-md uppercase tracking-wider">Libros</span>
                <span class="text-lg font-black text-gray-900">15,00€</span>
            </div>
            <h3 class="text-gray-800 font-bold text-sm mb-1">Libro de Matemáticas - 2º DAW</h3>
            <p class="text-gray-400 text-[11px]">Entrego en el aula 3 - Patio Central</p>
        </div>
    </div>
</header>

<section class="max-w-7xl mx-auto px-4 py-16">
    <h2 class="text-2xl font-black text-center text-gray-800 mb-12">¿Cómo funciona?</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
            <div class="w-10 h-10 bg-[#13c1ac] text-white rounded-xl flex items-center justify-center font-black text-lg mb-4">1</div>
            <h3 class="font-bold text-gray-800 mb-2">Regístrate gratis</h3>
            <p class="text-gray-500 text-xs leading-relaxed">Usa tu email del centro. Es un entorno privado y seguro solo para alumnos.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
            <div class="w-10 h-10 bg-[#13c1ac] text-white rounded-xl flex items-center justify-center font-black text-lg mb-4">2</div>
            <h3 class="font-bold text-gray-800 mb-2">Sube tus anuncios</h3>
            <p class="text-gray-500 text-xs leading-relaxed">Haz una foto, ponle precio y súbelo. Estará disponible para todos en segundos.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-xs">
            <div class="w-10 h-10 bg-[#13c1ac] text-white rounded-xl flex items-center justify-center font-black text-lg mb-4">3</div>
            <h3 class="font-bold text-gray-800 mb-2">Queda en el centro</h3>
            <p class="text-gray-500 text-xs leading-relaxed">Usa el chat integrado para concretar el punto de entrega. ¡Intercambio directo!</p>
        </div>
    </div>
</section>

<footer class="bg-white border-t border-gray-100 py-8 text-center">
    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">© 2026 SegundaClase. Proyecto TFG</p>
</footer>

</body>
</html>
