<?php

namespace Database\Seeders;

use App\Models\RumahSakit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminRsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil tenant pertama sebagai contoh
        $tenant = RumahSakit::first();

        if (!$tenant) {
            $this->command->error('Tidak ada tenant (Rumah Sakit) ditemukan. Admin RS tidak dapat dibuat.');
            return;
        }

        // Jalankan pembuatan admin dalam konteks tenant
        $tenant->execute(function () {
            // Cari atau buat user
            $adminUser = User::firstOrCreate(
                ['email' => 'admin@rumahsakit.test'],
                [
                    'name' => 'Admin RS',
                    'password' => bcrypt('password'),
                ]
            );

            // Cari peran 'admin_rs'
            $adminRsRole = Role::findByName('admin_rs', 'web');

            // Berikan peran ke user
            if ($adminRsRole) {
                $adminUser->assignRole($adminRsRole);
                $this->command->info('User Admin RS berhasil dibuat/ditemukan dan diberi peran.');
            } else {
                $this->command->error('Peran "admin_rs" tidak ditemukan. Pastikan seeder role sudah berjalan.');
            }
        });
    }
} 