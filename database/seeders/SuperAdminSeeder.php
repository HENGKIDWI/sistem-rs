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
        // Buat atau ambil user superadmin
        $user = User::firstOrCreate(
            ['email' => 'superadmin@rumahsakit.test'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
            ]
        );

        // Pastikan role 'super_admin' sudah ada
        $superAdminRole = Role::where('name', 'super_admin')->first();

        if ($superAdminRole) {
            // Berikan role jika belum
            if (!$user->hasRole('super_admin')) {
                $user->assignRole($superAdminRole);
            }
        }
        info('Seeding superadmin selesai untuk tenant: ' . config('database.connections.tenant.database'));

    }
}
