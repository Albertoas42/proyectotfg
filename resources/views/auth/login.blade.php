<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Pásamelo</title>
    <!-- Tailwind CSS CDN para mantener la coherencia estética -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900 min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">

<div class="sm:mx-auto w-full max-w-md">
    <!-- Logo / Regreso a Inicio -->
    <div class="text-center">
        <a href="{{ url('/') }}" class="text-3xl font-bold text-blue-600 tracking-tight flex items-center justify-center gap-2">
            <span>🏫</span> Pásamelo
        </a>
        <h2 class="mt-6 text-2xl font-extrabold text-gray-900 tracking-tight">
            Ingresa a tu cuenta
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            ¿Aún no formas parte?
            <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 transition">
                Regístrate aquí
            </a>
        </p>
    </div>

    <!-- Tarjeta del Formulario -->
    <div class="mt-8 sm:mx-auto w-full max-w-md">
        <div class="bg-white py-8 px-4 shadow-sm border border-gray-100 sm:rounded-2xl sm:px-10">

            <!-- Estado de la sesión (Ej: tras recuperar contraseña) -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-3 rounded-xl border border-green-100">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Formulario nativo de Laravel POST -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="tu_usuario@instituto.com"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-xl text-sm shadow-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                    </div>
                    @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center">
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-medium text-blue-600 hover:text-blue-500 transition">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required autocomplete="current-password"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-xl text-sm shadow-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                    </div>
                    @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded-md transition">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-600 select-none cursor-pointer">
                            Recordar mi sesión
                        </label>
                    </div>
                </div>

                <!-- Botón de Envío -->
                <div>
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition cursor-pointer">
                        Acceder a la plataforma
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
