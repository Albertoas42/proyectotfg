<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segunda Clase - Panel</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
</head>
<body class="bg-[#f4f6fa] font-sans antialiased text-gray-800 pb-20 md:pb-0" x-data="{ tab: 'catalogo' }">

<livewire:header />

<main class="max-w-6xl mx-auto px-4 py-6" x-show="tab === 'catalogo'">
</main>


<main class="max-w-4xl mx-auto px-4 py-6" x-show="tab === 'mensajes'" x-cloak>

</main>


@livewireScripts
</body>
</html>
