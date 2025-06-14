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
        // Buat user baru
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@rumahsakit.test',
            'password' => bcrypt('password') // Ganti dengan password yang aman
        ]);

        // Cari peran 'super_admin' yang sudah kita buat sebelumnya
        $superAdminRole = Role::where('name', 'super_admin')->first();

        // Berikan peran tersebut ke user
        if ($superAdminRole) {
            $user->assignRole($superAdminRole);
        }
    }
}