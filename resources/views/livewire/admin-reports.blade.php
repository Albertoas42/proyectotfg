<main class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-black text-gray-900 mb-8">🚩 Gestión de Reportes</h1>

    @forelse($reports as $report)
        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <a href="{{ route('products.show', $report->reported_product_id) }}"
                       target="_blank"
                       class="text-lg font-bold text-gray-800 hover:text-[#13c1ac] transition underline-offset-4 decoration-2">
                        Producto: {{ $report->product->title ?? 'Producto eliminado' }}
                    </a>

                    <p class="text-sm text-gray-600 mt-2">Motivo del reporte:
                        <span class="italic font-medium bg-gray-50 px-2 py-0.5 rounded border border-gray-100">
                    "{{ $report->reason }}"
                </span>
                    </p>

                    <p class="text-xs text-gray-400 mt-3 font-semibold">
                        Reportado por el usuario ID: {{ $report->reporter_id }} |
                        Hace: {{ $report->created_at->diffForHumans() }}
                    </p>
                </div>

                <div class="flex gap-2">
                    <button wire:click="dismiss({{ $report->report_id }})"
                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-xs transition cursor-pointer border-none">
                        Descartar
                    </button>
                    <button wire:click="deleteProduct({{ $report->report_id }})"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-xs transition cursor-pointer border-none">
                        Eliminar Anuncio
                    </button>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-20 text-gray-400">
            <p class="text-xl">✅ Todo bajo control. No hay reportes pendientes.</p>
        </div>
    @endforelse
</main>
