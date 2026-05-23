<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SchoolMarket - Tu Marketplace Escolar</title>
    <!-- Tailwind CSS CDN para un diseño rápido y moderno -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

<!-- Navbar / Barra de navegación superior -->
<nav class="bg-white shadow-xs sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex-shrink-0 flex items-center">
                <span class="text-2xl font-bold text-blue-600 tracking-tight">🏫 SchoolMarket</span>
            </div>
            <div class="flex space-x-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 bg-gray-100 px-4 py-2 rounded-lg transition">Entrar al Panel</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-blue-600 px-3 py-2 transition">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg shadow-xs transition">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>
</nav>

<!-- Hero Section / Presentación Principal -->
<header class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 flex flex-col lg:flex-row items-center justify-between gap-12">
        <div class="max-w-xl text-center lg:text-left">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight leading-none mb-6">
                Dale una segunda vida a tu <span class="text-blue-600">material escolar</span>
            </h1>
            <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                La plataforma exclusiva para alumnos y profesores de nuestro instituto. Vende los libros que ya no usas, encuentra apuntes, material de estudio y recógelo en mano durante el recreo. ¡Fácil, rápido y sostenible!
            </p>
            <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-md transition">
                        Explorar el Catálogo
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-blue-600 hover:bg-blue-700 shadow-md transition">
                        Empezar ahora
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 shadow-xs transition">
                        Ya tengo cuenta
                    </a>
                @endauth
            </div>
        </div>

        <div class="w-full max-w-md bg-linear-to-br from-blue-50 to-indigo-100 p-8 rounded-3xl border border-blue-100 shadow-xl flex flex-col items-center">
            <div class="bg-white p-5 rounded-2xl shadow-md w-full mb-4">
                <div class="w-full h-40 bg-gray-200 rounded-xl mb-4 flex items-center justify-center text-gray-400 font-medium">
                    📚 Imagen de muestra
                </div>
                <div class="flex justify-between items-start mb-2">
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Libros de texto</span>
                    <span class="text-xl font-bold text-gray-900">15,00€</span>
                </div>
                <h3 class="text-gray-900 font-bold text-lg mb-1">Libro de Matemáticas - 2º DAW</h3>
                <p class="text-gray-500 text-sm">Prácticamente nuevo, sin subrayar. Entrego en el aula 3.</p>
            </div>
            <span class="text-xs text-blue-600/70 font-medium tracking-wide uppercase">Simulación de la plataforma</span>
        </div>
    </div>
</header>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">¿Cómo funciona?</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-100">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl mb-4">1</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Regístrate gratis</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Utiliza tu correo del centro educativo para asegurar un entorno de confianza y 100% exclusivo para nuestra comunidad escolar.</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-100">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl mb-4">2</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Sube tus anuncios</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Hazle una foto a lo que ya no utilices, añade una breve descripción, ponle precio y súbelo al catálogo de forma instantánea.</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-xs border border-gray-100">
            <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl mb-4">3</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Queda en el centro</h3>
            <p class="text-gray-600 text-sm leading-relaxed">Reserva el producto en la web y habla con el vendedor por el chat interno para realizar el intercambio físico en el instituto de forma segura.</p>
        </div>
    </div>
</section>

<footer class="bg-gray-900 text-gray-400 py-8 border-t border-gray-800 text-center text-sm">
    <p>© 2026 SchoolMarket. Desarrollado como Proyecto de TFG de Desarrollo de Aplicaciones Web (DAW).</p>
</footer>

</body>
</html>
