<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportModal extends Component
{
    public $isOpen = false;
    public $productId;
    public $reason = 'Contenido inapropiado';

    protected $listeners = ['open-report-modal' => 'openModal'];

    public function openModal($productId)
    {
        $this->productId = $productId;
        $this->isOpen = true;
    }

    public function save()
    {
        $this->validate(['reason' => 'required|string|max:150']);

        Report::create([
            'reporter_id' => Auth::id(),
            'reported_product_id' => $this->productId,
            'reason' => $this->reason,
            'status' => 'pending'
        ]);

        $this->isOpen = false;
        session()->flash('message', 'Reporte enviado correctamente. El equipo de moderación lo revisará.');
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.report-modal');
    }
}
