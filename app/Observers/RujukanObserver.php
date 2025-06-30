<?php

namespace App\Observers;

use App\Models\Rujukan;
use App\Models\Appointment;
use App\Notifications\AppointmentCreated;

class RujukanObserver
{
    public function updated(Rujukan $rujukan)
    {
        // Jika status berubah menjadi approved
        if ($rujukan->isDirty('status') && $rujukan->status === 'approved') {
            // Buat appointment otomatis (jika belum ada)
            if (!Appointment::where('user_id', $rujukan->user_id)
                ->where('dokter_id', $rujukan->dokter_id)
                ->whereDate('tanggal_kunjungan', now()->addDays(1)->toDateString())
                ->exists()) {
                $appointment = Appointment::create([
                    'user_id' => $rujukan->user_id,
                    'dokter_id' => $rujukan->dokter_id, // Atau dokter tujuan
                    'tanggal_kunjungan' => now()->addDays(1),
                    'jam_kunjungan' => '09:00:00',
                    'keluhan' => 'Rujukan otomatis',
                    'status' => 'dijadwalkan',
                ]);
                // Kirim notifikasi ke pasien (dummy, pastikan Notification sudah ada)
                $rujukan->pasien?->notify(new AppointmentCreated($appointment));
            }
        }
    }
} 