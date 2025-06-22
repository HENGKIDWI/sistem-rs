<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RumahSakit;
use App\Models\Dokter;
use App\Models\Pasien;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Jalankan seeder untuk membuat Roles & Permissions terlebih dahulu
        $this->call(RolesAndPermissionsSeeder::class);

        // Ambil role yang sudah dibuat
        $superAdminRole = Role::findByName('super_admin');
        $adminRsRole    = Role::findByName('admin_rs');
        $dokterRole     = Role::findByName('dokter');
        $pasienRole     = Role::findByName('pasien');

        // 2. Buat Super Admin
        $superAdminUser = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@rumahsakit.test',
        ]);
        $superAdminUser->assignRole($superAdminRole);


        // 3. Buat Tenant "RS Sehat Selalu" dan isinya
        $rsSehat = RumahSakit::create(['name' => 'RS Sehat Selalu', 'domain' => 'rs-sehat.rumahsakit.test']);
        $rsSehat->execute(function () use ($adminRsRole, $dokterRole, $pasienRole) {
            
            // Buat Admin untuk RS Sehat
            $adminSehat = User::factory()->create(['name' => 'Admin RS Sehat', 'email' => 'admin@rs-sehat.test']);
            $adminSehat->assignRole($adminRsRole);

            // Buat satu Dokter spesifik untuk login
            $dokterUser = User::factory()->create([
                'name' => 'Dr. Budi Santoso',
                'email' => 'dokter@rs-sehat.test',
            ]);
            $dokterUser->assignRole($dokterRole);
            Dokter::factory()->create([
                'user_id' => $dokterUser->id,
                'nama_lengkap' => $dokterUser->name,
                'spesialisasi' => 'Jantung'
            ]);

            // Buat 2 Dokter acak lainnya
            User::factory(2)->create()->each(function ($user) use ($dokterRole) {
                $user->assignRole($dokterRole);
                Dokter::factory()->create(['user_id' => $user->id, 'nama_lengkap' => $user->name]);
            });

            // Buat 10 Pasien untuk RS Sehat
            User::factory(10)->create()->each(function ($user) use ($pasienRole) {
                $user->assignRole($pasienRole);
                Pasien::factory()->create(['user_id' => $user->id, 'nama' => $user->name]);
            });
        });

        // 4. Buat Tenant "RS Harapan Kita" dan isinya
        $rsHarapan = RumahSakit::create(['name' => 'RS Harapan Kita', 'domain' => 'rs-harapan.rumahsakit.test']);
        $rsHarapan->execute(function () use ($adminRsRole, $dokterRole, $pasienRole) {
            
            // Buat Admin untuk RS Harapan
            $adminHarapan = User::factory()->create(['name' => 'Admin RS Harapan', 'email' => 'admin@rs-harapan.test']);
            $adminHarapan->assignRole($adminRsRole);

            // Buat 2 Dokter untuk RS Harapan
            User::factory(2)->create()->each(function ($user) use ($dokterRole) {
                $user->assignRole($dokterRole);
                Dokter::factory()->create(['user_id' => $user->id, 'nama_lengkap' => $user->name]);
            });

            // Buat 5 Pasien untuk RS Harapan
            User::factory(5)->create()->each(function ($user) use ($pasienRole) {
                $user->assignRole($pasienRole);
                Pasien::factory()->create(['user_id' => $user->id, 'nama' => $user->name]);
            });
        });

        // 5. Panggil seeder lain jika ada (misal: pengumuman, fasilitas, dll)
        // Saat ini kita belum punya, jadi baris ini bisa dikosongkan/dihapus
        $this->call([
            // Contoh: PengumumanSeeder::class,
        ]);
    }
}