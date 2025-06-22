<?php

namespace App\Domain\Tenant\Http\Controllers;

use App\Http\Controllers\Controller;
use Spatie\Multitenancy\Models\Tenant;
use App\Models\Dokter;
use App\Models\Pengumuman;
use App\Models\GaleriFoto;
use App\Models\Fasilitas; // Asumsi Anda punya model Fasilitas
use Illuminate\Http\Request;

class LandingPageRsController extends Controller
{
    /**
     * Menampilkan halaman landing untuk tenant (rumah sakit) saat ini.
     * Halaman ini berisi informasi spesifik dari satu rumah sakit.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil data tenant yang sedang aktif (berdasarkan subdomain).
        // Ini adalah fitur inti dari spatie/laravel-multitenancy.
        $tenant = Tenant::current();

        // Jika karena suatu alasan tenant tidak ditemukan, tampilkan halaman 404.
        if (!$tenant) {
            abort(404, 'Halaman Rumah Sakit tidak ditemukan.');
        }

        // Mengambil data yang HANYA berhubungan dengan tenant ini.
        // Pastikan model Dokter, Pengumuman, dll., sudah menggunakan trait `UsesTenantConnection`.

        // Mengambil dokter dari tenant saat ini
        $dokters = Dokter::latest()->get();

        // Mengambil pengumuman dari tenant saat ini, diurutkan dari yang terbaru
        $announcements = Pengumuman::orderBy('tanggal', 'desc')->get();
        
        // Cara lain mengambil data melalui relasi dari model Tenant (lebih disarankan)
        $galeri = $tenant->galeriFotos()->latest()->take(6)->get();
        $fasilitas = $tenant->fasilitas()->get();

        // Kembalikan view untuk tenant dan kirim semua data spesifiknya
        return view('domain.tenant.landing', [
            'tenant' => $tenant,
            'dokters' => $dokters,
            'announcements' => $announcements,
            'galeri' => $galeri,
            'fasilitas' => $fasilitas,
        ]);
    }
}