<?php

// PASTIKAN NAMESPACE SESUAI DENGAN STRUKTUR FOLDER BARU
namespace App\Domain\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\RumahSakit;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Menyimpan data rumah sakit baru (tenant).
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:rumah_sakits,domain',
            'alamat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'jam_operasional' => 'nullable|string|max:255',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo_url')) {
            $path = $request->file('logo_url')->store('public/logos');
            $validatedData['logo_url'] = $path;
        }

        // Karena menggunakan single database, kita tidak perlu membuat 'database'
        $rumahSakit = RumahSakit::create($validatedData);

        return redirect()->route('superadmin.dashboard')
                         ->with('success', 'Rumah Sakit berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit data rumah sakit.
     */
    public function edit(RumahSakit $rumahSakit): View
    {
        return view('domain.admin.tenants.edit', compact('rumahSakit'));
    }

    /**
     * Memperbarui data rumah sakit di database.
     */
    public function update(Request $request, RumahSakit $rumahSakit)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:rumah_sakits,domain,' . $rumahSakit->id,
            'alamat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
            'jam_operasional' => 'nullable|string|max:255',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('logo_url')) {
            // Hapus logo lama jika ada
            if ($rumahSakit->logo_url) {
                Storage::delete($rumahSakit->logo_url);
            }
            $path = $request->file('logo_url')->store('public/logos');
            $validatedData['logo_url'] = $path;
        }

        $rumahSakit->update($validatedData);

        return redirect()->route('superadmin.dashboard')
                         ->with('success', 'Data Rumah Sakit berhasil diperbarui.');
    }

    /**
     * Menghapus data rumah sakit dari database.
     */
    public function destroy(RumahSakit $rumahSakit)
    {
        // Hapus logo dari storage jika ada
        if ($rumahSakit->logo_url) {
            Storage::delete($rumahSakit->logo_url);
        }

        $rumahSakit->delete();

        return redirect()->route('superadmin.dashboard')
                         ->with('success', 'Rumah Sakit berhasil dihapus.');
    }
}