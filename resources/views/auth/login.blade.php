<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Segunda Vida</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#f4f6fa] font-sans antialiased text-gray-800 min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">

<div class="sm:mx-auto w-full max-w-md">
    <div class="text-center">
        <a href="{{ url('/') }}" class="text-3xl font-black text-[#13c1ac] tracking-tight flex items-center justify-center gap-2">
            <span>💚</span> Segunda Vida
        </a>
        <h2 class="mt-6 text-2xl font-black text-gray-900 tracking-tight">
            Ingresa a tu cuenta
        </h2>
        <p class="mt-2 text-sm text-gray-500 font-medium">
            ¿Aún no formas parte?
            <a href="{{ route('register') }}" class="font-bold text-[#13c1ac] hover:text-[#0fa895] transition">
                Regístrate aquí
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto w-full max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl border border-gray-100 rounded-3xl sm:px-10">

            @if (session('status'))
                <div class="mb-4 font-bold text-sm text-green-700 bg-green-50 p-3 rounded-xl border border-green-100">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Correo electrónico</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#13c1ac] focus:ring-1 focus:ring-[#13c1ac] transition">
                    @error('email')
                    <p class="mt-1 text-xs text-red-600 font-bold">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Contraseña</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#13c1ac] hover:text-[#0fa895] transition">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    <input id="password" name="password" type="password" required
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#13c1ac] focus:ring-1 focus:ring-[#13c1ac] transition">
                </div>

                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox"
                           class="h-4 w-4 text-[#13c1ac] focus:ring-[#13c1ac] border-gray-300 rounded cursor-pointer">
                    <label for="remember_me" class="ml-2 block text-sm font-medium text-gray-600 select-none cursor-pointer">
                        Recordar mi sesión
                    </label>
                </div>

                <div>
                    <button type="submit" class="w-full py-3.5 bg-[#13c1ac] hover:bg-[#0fa895] text-white text-sm font-black rounded-xl shadow-lg transition cursor-pointer border-none mt-2">
                        Acceder a la plataforma
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
