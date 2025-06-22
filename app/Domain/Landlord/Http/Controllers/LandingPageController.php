<?php

namespace App\Domain\Landlord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RumahSakit;
use Illuminate\View\View;

class LandingPageController extends Controller
{
    /**
     * Menampilkan halaman landing utama untuk landlord.
     * Halaman ini akan menampilkan daftar semua rumah sakit (tenant).
     */
    public function index(): View
    {
        $tenants = RumahSakit::all();
        
        return view('domain.landlord.index', ['tenants' => $tenants]);
    }
}
