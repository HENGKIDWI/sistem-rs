<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cache permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- DEFINISIKAN PERMISSIONS ---
        Permission::create(['name' => 'kelola_rs', 'guard_name' => 'web']);
        Permission::create(['name' => 'kelola_dokter', 'guard_name' => 'web']);
        Permission::create(['name' => 'lihat_rekam_medis', 'guard_name' => 'web']);
        Permission::create(['name' => 'buat_rujukan', 'guard_name' => 'web']);
        Permission::create(['name' => 'kelola_pasien', 'guard_name' => 'web']);
        Permission::create(['name' => 'kelola_antrian', 'guard_name' => 'web']);


        // --- DEFINISIKAN ROLES ---
        $superAdminRole = Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        $adminRsRole = Role::create(['name' => 'admin_rs', 'guard_name' => 'web']);
        $dokterRole = Role::create(['name' => 'dokter', 'guard_name' => 'web']);
        $pasienRole = Role::create(['name' => 'pasien', 'guard_name' => 'web']);


        // --- BERIKAN PERMISSIONS KE ROLES ---

        // Super Admin bisa melakukan segalanya
        $superAdminRole->givePermissionTo(Permission::all());

        // Admin RS bisa mengelola dokter, pasien, dan antrian di RS-nya
        $adminRsRole->givePermissionTo([
            'kelola_dokter',
            'kelola_pasien',
            'kelola_antrian',
        ]);

        // Dokter bisa melihat rekam medis dan membuat rujukan
        $dokterRole->givePermissionTo([
            'lihat_rekam_medis',
            'buat_rujukan',
        ]);

        // Pasien hanya bisa melihat rekam medisnya sendiri (logika ini akan ada di controller,
        // permission ini sebagai penanda)
        $pasienRole->givePermissionTo('lihat_rekam_medis');
    }
}