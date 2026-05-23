<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - SchoolMarket</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900 min-h-screen flex flex-col justify-center py-12 sm:px-6 lg:px-8">

<div class="sm:mx-auto w-full max-w-md">
    <div class="text-center">
        <a href="{{ url('/') }}" class="text-3xl font-bold text-blue-600 tracking-tight flex items-center justify-center gap-2">
            <span>🏫</span> Pásamelo
        </a>
        <h2 class="mt-6 text-2xl font-extrabold text-gray-900 tracking-tight">
            Crea tu cuenta de alumno o profesor
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 transition">
                Inicia sesión aquí
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto w-full max-w-md">
        <div class="bg-white py-8 px-4 shadow-sm border border-gray-100 sm:rounded-2xl sm:px-10">

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input id="first_name" name="first_name" type="text" value="{{ old('first_name') }}" required autofocus autocomplete="given-name"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-xl text-sm shadow-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('first_name') border-red-500 @enderror">
                        @error('first_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Apellidos</label>
                        <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required autocomplete="family-name"
                               class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-xl text-sm shadow-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('last_name') border-red-500 @enderror">
                        @error('last_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico del centro</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" placeholder="ejemplo@instituto.com"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-xl text-sm shadow-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                    </div>
                    @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-xl text-sm shadow-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                    </div>
                    @error('password')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    <p class="mt-1 text-xs text-gray-500">Mínimo 8 caracteres.</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-xl text-sm shadow-xs placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    @error('password_confirmation')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition cursor-pointer">
                        Registrar mi cuenta
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
