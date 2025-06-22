<?php

namespace App\Listeners;

use App\Models\Pasien; // <-- 1. TAMBAHKAN USE STATEMENT INI
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AssignDefaultRole
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;

        // 2. Berikan peran 'pasien' kepada user tersebut.
        $user->assignRole('pasien');

        // 3. BUAT PROFIL PASIEN YANG TERHUBUNG SECARA OTOMATIS
        Pasien::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            // Isi data default lainnya jika perlu
            'nomor_rekam_medis' => 'RM-' . time() . $user->id, // Contoh nomor rekam medis unik
            'tanggal_lahir' => '1990-01-01', // Anda bisa set default atau null
            'alamat' => 'Alamat belum diisi', // Anda bisa set default atau null
        ]);
    }
}