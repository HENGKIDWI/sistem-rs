<?php

namespace App\Domain\Tenant\Http\Controllers;

use App\Http\Controllers\Controller; // Pastikan meng-extend Controller utama
use Illuminate\Http\Request;
use Illuminate\View\View; // Import class View

class DokterController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk Dokter.
     */
    public function dashboard(): View
    {
        // Logika untuk mengambil data yang dibutuhkan dokter bisa ditambahkan di sini
        // seperti daftar pasien, jadwal, dll.

        // Mengembalikan view yang berada di resources/views/tenant/dokter/dashboard.blade.php
        return view('domain.tenant.dokter.dashboard');
    }

    /**
     * Menampilkan halaman rujukan untuk Dokter.
     * (Ini sesuai dengan rute 'dokter.rujukan.show' yang kita buat di web.php)
     */
    public function showRujukan(): View
    {
        // Logika untuk menampilkan data rujukan
        return view('domain.tenant.dokter.rujukan');
    }
}