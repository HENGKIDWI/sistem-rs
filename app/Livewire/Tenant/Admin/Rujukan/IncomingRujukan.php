<?php

namespace App\Livewire\Tenant\Admin\Rujukan;

use App\Models\Rujukan;
use App\Models\RumahSakit;
use App\Models\User;
use App\Models\Dokter;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class IncomingRujukan extends Component
{
    use WithPagination;

    public $isModalOpen = false;
    public $rujukanToReject;
    public $rejectionReason = '';
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $currentTenantId = app('currentTenant')->id;
        
        // Log the tenant ID we are querying for
        Log::info('Fetching incoming rujukan for tenant ID: ' . $currentTenantId);

        $rujukans = Rujukan::where('rs_tujuan_id', $currentTenantId)
            ->where('status', 'pending_rs_approval')
            ->with(['pasien', 'dokter', 'rumahSakitSumber'])
            ->latest()
            ->paginate(10);
        
        // Log the count of found rujukans
        Log::info('Found ' . $rujukans->total() . ' pending rujukans.');
            
        return view('livewire.tenant.admin.rujukan.incoming-rujukan', [
            'rujukans' => $rujukans,
        ])->layout('layouts.app');
    }

    public function approve($rujukanId)
    {
        $rujukan = Rujukan::findOrFail($rujukanId);
        $rujukan->update(['status' => 'pending_patient_approval']);
        
        // TODO: Kirim notifikasi ke pasien
        
        session()->flash('message', 'Rujukan telah disetujui dan sedang menunggu konfirmasi dari pasien.');
    }

    public function openRejectModal($rujukanId)
    {
        $this->rujukanToReject = Rujukan::findOrFail($rujukanId);
        $this->isModalOpen = true;
    }

    public function reject()
    {
        $this->validate(['rejectionReason' => 'required|string|min:10']);

        if ($this->rujukanToReject) {
            $this->rujukanToReject->update([
                'status' => 'rejected_by_rs',
                'catatan_balasan' => $this->rejectionReason,
            ]);
            
            // TODO: Kirim notifikasi ke dokter perujuk

            session()->flash('message', 'Rujukan telah ditolak.');
            $this->closeModal();
        }
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset(['rujukanToReject', 'rejectionReason']);
    }
}
