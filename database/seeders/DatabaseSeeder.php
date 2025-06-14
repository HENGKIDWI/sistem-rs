<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RumahSakit;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // 1. Jalankan seeder Roles & Super Admin
        $this->call([RolesAndPermissionsSeeder::class, SuperAdminSeeder::class]);

        $dokterRole = Role::findByName('dokter');
        $pasienRole = Role::findByName('pasien');
        $adminRsRole = Role::findByName('admin_rs');

        // 2. Buat Tenant
        $rsHarapan = RumahSakit::create(['name' => 'RS Harapan Kita', 'domain' => 'rsharapan.rumahsakit.test']);

        // 3. Isi data untuk tenant RS Harapan
        $rsHarapan->execute(function () use ($dokterRole, $pasienRole, $adminRsRole) {

            // Buat Admin RS
            $adminUser = User::factory()->create(['name' => 'Admin RS Harapan', 'email' => 'admin@rsharapan.test']);
            $adminUser->assignRole($adminRsRole);

            // Buat 3 Dokter
            User::factory(3)->create()->each(function ($user) use ($dokterRole) {
                $user->assignRole($dokterRole);
                \App\Models\Dokter::factory()->create(['user_id' => $user->id, 'nama_lengkap' => $user->name]);
            });

            // Buat 10 Pasien
            User::factory(10)->create()->each(function ($user) use ($pasienRole) {
                $user->assignRole($pasienRole);
                \App\Models\Pasien::factory()->create(['user_id' => $user->id, 'nama' => $user->name]);
            });
        });
        // Hapus atau komentari user factory default jika tidak diperlukan sekarang
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Panggil seeder yang baru kita buat
        $this->call([
            RolesAndPermissionsSeeder::class,
            SuperAdminSeeder::class,
        ]);
    }
}