<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segunda Clase - Wallapop Escolar</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    @livewireStyles
</head>
<body class="bg-[#f4f6fa] font-sans antialiased text-gray-800 pb-20 md:pb-0">

<livewire:header />

{{ $slot }}

@livewireScripts
</body>
</html>
