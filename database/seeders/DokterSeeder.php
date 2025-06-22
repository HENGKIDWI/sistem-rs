<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dokter;
use App\Models\RumahSakit;
use App\Models\User;

class DokterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil salah satu tenant (rumah sakit) untuk dihubungkan
        $tenant = RumahSakit::first();

        if ($tenant) {
            $dokters = [
                [
                    'nama_lengkap' => 'Dr. Budi Santoso',
                    'email' => 'budi.santoso@rumahsakit.test',
                    'spesialisasi' => 'Dokter Umum',
                    'nomor_str' => '111222333444555',
                    'status' => 'aktif',
                    'jam_mulai' => '09:00:00',
                    'jam_selesai' => '17:00:00',
                    'durasi_konsultasi' => 30,
                ],
                [
                    'nama_lengkap' => 'Dr. Anisa Putri',
                    'email' => 'anisa.putri@rumahsakit.test',
                    'spesialisasi' => 'Dokter Gigi',
                    'nomor_str' => '222333444555666',
                    'status' => 'aktif',
                    'jam_mulai' => '10:00:00',
                    'jam_selesai' => '18:00:00',
                    'durasi_konsultasi' => 45,
                ],
                [
                    'nama_lengkap' => 'Dr. Chandra Wijaya',
                    'email' => 'chandra.wijaya@rumahsakit.test',
                    'spesialisasi' => 'Penyakit Dalam',
                    'nomor_str' => '333444555666777',
                    'status' => 'tidak_aktif',
                    'jam_mulai' => '08:00:00',
                    'jam_selesai' => '15:00:00',
                    'durasi_konsultasi' => 20,
                ],
            ];

            foreach ($dokters as $dokterData) {
                // 2. Buat atau cari user untuk dokter
                $user = User::firstOrCreate(
                    ['email' => $dokterData['email']],
                    [
                        'name' => $dokterData['nama_lengkap'],
                        'password' => bcrypt('password'), // Password default
                    ]
                );
                $user->assignRole('dokter'); // Berikan role dokter

                // 3. Tambahkan user_id ke data dokter sebelum dibuat
                $dokterData['user_id'] = $user->id;

                // Hapus email dari array agar tidak coba dimasukkan ke tabel dokters
                unset($dokterData['email']); 

                Dokter::updateOrCreate(
                    ['nama_lengkap' => $dokterData['nama_lengkap'], 'tenant_id' => $tenant->id],
                    $dokterData
                );
            }
        } else {
            $this->command->info('Tidak ada Rumah Sakit (tenant) ditemukan. Seeder Dokter tidak dijalankan.');
        }
    }
}