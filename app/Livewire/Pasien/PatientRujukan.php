<?php

namespace App\Livewire\Pasien;

use App\Models\Rujukan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PatientRujukan extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $rujukans = Rujukan::where('user_id', Auth::id())
            ->whereIn('status', ['pending_patient_approval', 'approved', 'rejected_by_rs', 'cancelled_by_patient'])
            ->with(['rumahSakitSumber', 'rumahSakitTujuan', 'dokter'])
            ->latest()
            ->paginate(10);

        return view('livewire.pasien.patient-rujukan', [
            'rujukans' => $rujukans
        ])->layout('layouts.app');
    }

    public function approve($rujukanId)
    {
        $rujukan = Rujukan::where('user_id', Auth::id())->findOrFail($rujukanId);
        
        if ($rujukan->status === 'pending_patient_approval') {
            $rujukan->update(['status' => 'approved']);
            session()->flash('message', 'Rujukan telah Anda setujui. Silakan hubungi rumah sakit tujuan untuk penjadwalan.');
        }
    }

    public function cancel($rujukanId)
    {
        $rujukan = Rujukan::where('user_id', Auth::id())->findOrFail($rujukanId);

        if ($rujukan->status === 'pending_patient_approval') {
            $rujukan->update(['status' => 'cancelled_by_patient']);
            session()->flash('message', 'Rujukan telah Anda batalkan.');
        }
    }
}
