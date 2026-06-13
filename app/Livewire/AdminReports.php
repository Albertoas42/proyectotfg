<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Report;

class AdminReports extends Component
{
    public function dismiss($reportId) {
        Report::find($reportId)->update(['status' => 'dismissed']);
    }

    public function deleteProduct($reportId) {
        $report = Report::find($reportId);
        if ($report && $report->product) {
            $report->product->delete();
            $report->update(['status' => 'reviewed']);
        }
    }

    public function render() {
        return view('livewire.admin-reports', [
            'reports' => Report::where('status', 'pending')->with(['product', 'reporter'])->get()
        ]);
    }
}
