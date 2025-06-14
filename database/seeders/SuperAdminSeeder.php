<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari user berdasarkan email, jika tidak ada, buat baru.
        $user = User::firstOrCreate(
            ['email' => 'superadmin@rumahsakit.test'], // Kriteria unik untuk mencari
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password') // Data untuk membuat jika tidak ada
            ]
        );

        // Cari peran 'super_admin'
        $superAdminRole = Role::findByName('super_admin');

        // Berikan peran ke user (assignRole sudah cukup cerdas untuk tidak duplikat)
        if ($superAdminRole) {
            $user->assignRole($superAdminRole);
        }
    }
}