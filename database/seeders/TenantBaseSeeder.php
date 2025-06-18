<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Pasien;
use Spatie\Permission\Models\Role;

class TenantBaseSeeder extends Seeder
{
    /**
     * Run the database seeds for a tenant.
     */
    public function run(): void
    {
        // 1. Buat role admin rumah sakit jika belum ada
        $adminRole = Role::firstOrCreate(['name' => 'admin_rs']);

        // 2. Buat user admin RS
        $admin = User::firstOrCreate(
            ['email' => 'admin@rs.test'],
            [
                'name' => 'Admin RS',
                'password' => bcrypt('password')
            ]
        );

        // 3. Assign role
        if (!$admin->hasRole('admin_rs')) {
            $admin->assignRole($adminRole);
        }

        // 4. Buat dokter dummy
        Dokter::firstOrCreate([
            'user_id' => null,
            'nama_lengkap' => 'dr. Rina',
            'spesialisasi' => 'Umum',
            'nomor_str' => 'STR001'
        ]);

        Pasien::firstOrCreate([
            'user_id' => null,
            'nama' => 'Budi Santoso',
            'nomor_rekam_medis' => 'RM001',
            'tanggal_lahir' => '1990-05-01',
            'alamat' => 'Jl. Sehat No. 123',
            'nomor_telepon' => '08123456789'
        ]);

    }
}
