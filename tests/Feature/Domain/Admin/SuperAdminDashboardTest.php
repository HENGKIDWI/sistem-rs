<?php

namespace Tests\Feature\Domain\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class SuperAdminDashboardTest extends TestCase
{
    use RefreshDatabase; // Otomatis reset database untuk setiap test

    protected function setUp(): void
    {
        parent::setUp();
        // Jalankan seeder roles & permissions sebelum setiap test
        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    /** @test */
    public function tamu_tidak_bisa_mengakses_dashboard_super_admin()
    {
        $response = $this->get('http://admin.rumahsakit.test');

        // Harusnya diarahkan ke halaman login
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function pengguna_tanpa_peran_super_admin_ditolak()
    {
        // Buat user biasa (tanpa peran super_admin)
        $user = User::factory()->create();
        $dokterRole = Role::findByName('dokter');
        $user->assignRole($dokterRole);

        $response = $this->actingAs($user)->get('http://admin.rumahsakit.test');

        // Harusnya mendapatkan error 403 Forbidden
        $response->assertStatus(403);
    }

    /** @test */
    public function super_admin_bisa_mengakses_dashboard()
    {
        // Buat user dan berikan peran super_admin
        $superAdminUser = User::factory()->create();
        $superAdminRole = Role::findByName('super_admin');
        $superAdminUser->assignRole($superAdminRole);

        // Bertindak sebagai user ini dan kunjungi halaman
        $response = $this->actingAs($superAdminUser)->get('http://admin.rumahsakit.test');

        // Pastikan response sukses
        $response->assertStatus(200);

        // Pastikan view yang ditampilkan benar dan berisi teks yang diharapkan
        $response->assertViewIs('domain.admin.dashboard');
        $response->assertSee('Dashboard Super Admin');
        $response->assertSee('Daftar Rumah Sakit (Tenant)');
    }
}