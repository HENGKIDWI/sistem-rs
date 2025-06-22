<?php

namespace App\Livewire\Dokter;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use Livewire\Component;

class CreateMedicalRecord extends Component
{
    public $isModalOpen = false;
    public $appointment;
    public $diagnosis, $tindakan, $resep_obat, $catatan;

    protected $listeners = ['open-medical-record-modal' => 'openModal'];

    protected function rules()
    {
        return [
            'diagnosis' => 'required|string|min:5',
            'tindakan' => 'required|string|min:5',
            'resep_obat' => 'nullable|string',
            'catatan' => 'nullable|string',
        ];
    }

    public function openModal($appointmentId)
    {
        $this->appointment = Appointment::with('user')->findOrFail($appointmentId);
        $this->isModalOpen = true;
    }

    public function store()
    {
        $this->validate();

        MedicalRecord::create([
            'appointment_id' => $this->appointment->id,
            'diagnosis' => $this->diagnosis,
            'tindakan' => $this->tindakan,
            'resep_obat' => $this->resep_obat,
            'catatan_dokter' => $this->catatan,
        ]);

        // Tandai appointment sebagai 'selesai'
        $this->appointment->update(['status' => 'selesai']);

        session()->flash('message', 'Rekam medis berhasil disimpan.');
        $this->closeModal();
        
        // Refresh halaman untuk memperbarui daftar janji temu
        return redirect()->route('dokter.dashboard');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset(['appointment', 'diagnosis', 'tindakan', 'resep_obat', 'catatan']);
    }

    public function render()
    {
        return view('livewire.dokter.create-medical-record');
    }
}
