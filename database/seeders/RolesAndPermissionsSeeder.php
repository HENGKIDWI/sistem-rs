<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Gunakan updateOrCreate untuk Permissions
        $permissions = [
            'view-admin-dashboard',
            'kelola_rs',
            'kelola_dokter',
            'lihat_rekam_medis',
            'buat_rujukan',
            'kelola_pasien',
            'kelola_antrian'
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission, 'guard_name' => 'web'], ['name' => $permission]);
        }

        // Gunakan updateOrCreate untuk Roles
        $superAdminRole = Role::updateOrCreate(['name' => 'super_admin', 'guard_name' => 'web'], ['name' => 'super_admin']);
        $adminRsRole = Role::updateOrCreate(['name' => 'admin_rs', 'guard_name' => 'web'], ['name' => 'admin_rs']);
        $dokterRole = Role::updateOrCreate(['name' => 'dokter', 'guard_name' => 'web'], ['name' => 'dokter']);
        $pasienRole = Role::updateOrCreate(['name' => 'pasien', 'guard_name' => 'web'], ['name' => 'pasien']);

        // Berikan permissions ke roles (syncPermissions lebih aman dari duplikasi)
        $superAdminRole->syncPermissions(Permission::all());
        $adminRsRole->syncPermissions(['view-admin-dashboard', 'kelola_dokter', 'kelola_pasien', 'kelola_antrian']);
        $dokterRole->syncPermissions(['lihat_rekam_medis', 'buat_rujukan']);
        $pasienRole->syncPermissions(['lihat_rekam_medis']);
    }
}