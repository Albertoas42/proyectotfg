<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Segunda Vida</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#f4f6fa] font-sans antialiased text-gray-800 min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">

<div class="sm:mx-auto w-full max-w-md">
    <div class="text-center">
        <a href="{{ url('/') }}" class="text-3xl font-black text-[#13c1ac] tracking-tight flex items-center justify-center gap-2">
            <span>💚</span> Segunda Vida
        </a>
        <h2 class="mt-6 text-2xl font-black text-gray-900 tracking-tight">
            Crea tu cuenta
        </h2>
        <p class="mt-2 text-sm text-gray-500 font-medium">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="font-bold text-[#13c1ac] hover:text-[#0fa895] transition">
                Inicia sesión aquí
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto w-full max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl border border-gray-100 rounded-3xl sm:px-10">

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nombre</label>
                        <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required autofocus
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#13c1ac] focus:ring-1 focus:ring-[#13c1ac] transition">
                    </div>
                    <div>
                        <label for="last_name" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Apellidos</label>
                        <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#13c1ac] focus:ring-1 focus:ring-[#13c1ac] transition">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Correo institucional</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required placeholder="ejemplo@murciaeduca.es"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#13c1ac] focus:ring-1 focus:ring-[#13c1ac] transition">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Contraseña</label>
                    <input id="password" name="password" type="password" required
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#13c1ac] focus:ring-1 focus:ring-[#13c1ac] transition">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Confirmar contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#13c1ac] focus:ring-1 focus:ring-[#13c1ac] transition">
                </div>

                <div>
                    <button type="submit" class="w-full py-3.5 bg-[#13c1ac] hover:bg-[#0fa895] text-white text-sm font-black rounded-xl shadow-lg transition cursor-pointer border-none mt-2">
                        Registrar mi cuenta
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
