<?php

namespace App\Livewire\Tenant\Admin\Appointment;

use App\Models\Appointment;
use Livewire\Component;
use Livewire\WithPagination;

class ManageAppointments extends Component
{
    use WithPagination;

    public $isModalOpen = false;
    public $appointmentId, $status, $tanggal_kunjungan, $jam_kunjungan;
    public $statuses = ['pending', 'confirmed', 'completed', 'canceled'];
    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        return [
            'status' => 'required|in:' . implode(',', $this->statuses),
            'tanggal_kunjungan' => 'required|date',
            'jam_kunjungan' => 'required|date_format:H:i',
        ];
    }

    public function render()
    {
        // Ambil semua appointment milik tenant ini
        // Kita asumsikan dokter terikat pada tenant, jadi kita join melalui dokter
        $appointments = Appointment::whereHas('dokter', function ($query) {
            $query->where('tenant_id', app('currentTenant')->id);
        })->with(['user', 'dokter'])->latest()->paginate(10);

        return view('livewire.tenant.admin.appointment.manage-appointments', [
            'appointments' => $appointments,
        ])->layout('layouts.app');
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);
        $this->appointmentId = $id;
        $this->status = $appointment->status;
        $this->tanggal_kunjungan = $appointment->tanggal_kunjungan->format('Y-m-d');
        $this->jam_kunjungan = $appointment->jam_kunjungan->format('H:i');
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        if ($this->appointmentId) {
            $appointment = Appointment::findOrFail($this->appointmentId);
            $appointment->update([
                'status' => $this->status,
                'tanggal_kunjungan' => $this->tanggal_kunjungan,
                'jam_kunjungan' => $this->jam_kunjungan,
            ]);
            session()->flash('message', 'Janji temu berhasil diperbarui.');
        }

        $this->closeModal();
    }
    
    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset(['appointmentId', 'status', 'tanggal_kunjungan', 'jam_kunjungan']);
    }
}
