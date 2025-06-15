<?php

namespace App\Domain\Tenant\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Menampilkan dashboard untuk pasien.
     */
    public function dashboard()
    {
        // Mengarahkan ke folder: domain -> tenant -> pasien -> dashboard.blade.php
        return view('domain.tenant.pasien.dashboard');
    }

    // Mungkin ada fungsi lain di sini...
}