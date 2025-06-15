<?php
// File: app/Domain/Landlord/Http/Controllers/LandingPageController.php
namespace App\Domain\Landlord\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RumahSakit;
use Illuminate\Http\Request; // <-- Tambahkan

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar, hanya ambil RS yang aktif
        $query = RumahSakit::where('status', true);

        // Jika ada input pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $daftarRumahSakit = $query->get();

        return view('welcome', compact('daftarRumahSakit'));
    }
}