<?php

namespace App\Livewire\Dokter;

use App\Models\Appointment;
use App\Models\RumahSakit;
use App\Models\User;
use App\Models\Rujukan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CreateRujukan extends Component
{
    public $isModalOpen = false;
    public $pasien;
    public $appointment;
    public $rumahSakitTujuanId, $alasan_rujukan, $catatan_dokter;
    public $rumahSakitList;

    protected $listeners = ['open-create-rujukan-modal' => 'openModal'];

    protected function rules()
    {
        return [
            'rumahSakitTujuanId' => 'required|exists:rumah_sakits,id',
            'alasan_rujukan' => 'required|string|min:10',
            'catatan_dokter' => 'nullable|string',
        ];
    }

    public function openModal($appointmentId)
    {
        $this->appointment = Appointment::with('user')->findOrFail($appointmentId);
        $this->pasien = $this->appointment->user;
        $currentTenantId = app('currentTenant')->id;
        $this->rumahSakitList = RumahSakit::where('id', '!=', $currentTenantId)->get();
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate([
            'rumahSakitTujuanId' => 'required|different:currentTenant',
            'alasan_rujukan' => 'required',
        ], [
            'rumahSakitTujuanId.different' => 'Rumah Sakit tujuan tidak boleh sama dengan rumah sakit asal.',
        ]);

        if ($this->rumahSakitTujuanId == app('currentTenant')->id) {
            session()->flash('error', 'Rumah Sakit tujuan tidak boleh sama dengan rumah sakit asal.');
            return;
        }

        $dokter = Auth::user()->dokter;
        if (!$dokter) {
            session()->flash('error', 'Tidak dapat menemukan data dokter yang sesuai.');
            return;
        }

        $dataToCreate = [
            'appointment_id' => $this->appointment->id,
            'user_id' => $this->pasien->id,
            'dokter_id' => $dokter->id,
            'rs_sumber_id' => app('currentTenant')->id,
            'rs_tujuan_id' => $this->rumahSakitTujuanId,
            'alasan_rujukan' => $this->alasan_rujukan,
            'catatan_dokter' => $this->catatan_dokter,
            'status' => 'pending_rs_approval',
        ];

        Log::info('Attempting to create rujukan with data:', $dataToCreate);

        try {
            Rujukan::create($dataToCreate);
            Log::info('Rujukan created successfully!');
            session()->flash('message', 'Rujukan berhasil dibuat dan sedang menunggu persetujuan dari rumah sakit tujuan.');
            $this->closeModal();
        } catch (\Exception $e) {
            Log::error('Failed to create rujukan: ' . $e->getMessage());
            session()->flash('error', 'Gagal membuat rujukan. Silakan coba lagi.');
        }
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset(['pasien', 'appointment', 'rumahSakitTujuanId', 'alasan_rujukan', 'catatan_dokter', 'rumahSakitList']);
    }

    public function render()
    {
        return view('livewire.dokter.create-rujukan');
    }
}
