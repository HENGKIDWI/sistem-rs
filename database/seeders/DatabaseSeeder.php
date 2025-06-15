<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\RumahSakit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $superAdminRole = Role::findByName('super_admin');

        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@rumahsakit.test',
            'password' => bcrypt('password'),
        ])->assignRole($superAdminRole);

        // --- Blok Pembuatan Tenant ---
        $dbName = 'tenant_rsharapan';

        // 1. Buat database secara manual
        DB::connection('landlord')->statement("CREATE DATABASE IF NOT EXISTS `$dbName`");

        // 2. Buat record tenant
        RumahSakit::create([
            'name'     => 'RS Harapan Kita',
            'domain'   => 'rsharapan.rumahsakit.test',
            'database' => $dbName,
            'status'   => true,
        ]);
        // --- Akhir Blok Pembuatan Tenant ---
    }
}