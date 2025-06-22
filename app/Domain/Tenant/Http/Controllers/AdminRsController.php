<?php

namespace App\Domain\Tenant\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminRsController extends Controller
{
    /**
     * Menampilkan dashboard untuk Admin RS.
     */
    public function dashboard(): View
    {
        // TODO: Isi dengan statistik atau informasi relevan untuk Admin RS
        return view('domain.tenant.admin_rs.dashboard');
    }

    /**
     * Menampilkan halaman untuk mengelola data dokter.
     */
    public function manageDokter(): View
    {
        $currentTenant = \Spatie\Multitenancy\Facades\Tenant::current();

        $dokters = Dokter::where('tenant_id', $currentTenant->id)
            ->with('user') 
            ->orderBy('nama_lengkap', 'asc')
            ->paginate(15); 

        return view('domain.tenant.admin_rs.dokter.index', [
            'dokters' => $dokters,
        ]);
    }

    public function createDokter(): View
    {
        return view('domain.tenant.admin_rs.dokter.create');
    }

    public function storeDokter(Request $request)
    {
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'spesialisasi' => ['required', 'string', 'max:255'],
            'nomor_telepon' => ['required', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('dokter');

        Dokter::create([
            'user_id' => $user->id,
            'tenant_id' => \Spatie\Multitenancy\Facades\Tenant::current()->id,
            'nama_lengkap' => $request->nama_lengkap,
            'spesialisasi' => $request->spesialisasi,
            'nomor_telepon' => $request->nomor_telepon,
        ]);

        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil ditambahkan.');
    }
}
