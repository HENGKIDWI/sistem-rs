<?php

// PASTIKAN NAMESPACE SESUAI DENGAN STRUKTUR FOLDER BARU
namespace App\Domain\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\RumahSakit;

class SuperAdminController extends Controller
{
    /**
     * Menampilkan halaman dashboard Super Admin.
     */
    public function dashboard(): View
    {
        // Ambil semua data rumah sakit dari database
        $daftarRumahSakit = RumahSakit::all();

        // Kirim data tersebut ke view 'domain.admin.dashboard'
        return view('domain.admin.dashboard', [
            'daftarRumahSakit' => $daftarRumahSakit
        ]);
    }
}