<?php
// File: app/Domain/Admin/Http/Controllers/SuperAdminController.php

namespace App\Domain\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RumahSakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    /**
     * Menampilkan dashboard dengan daftar semua rumah sakit.
     */
    public function dashboard()
    {
        // 1. Ambil daftar RS
        $daftarRumahSakit = RumahSakit::all();

        // 2. Siapkan variabel total
        $totalPasien = 0;
        $totalDokter = 0;

        // 3. Iterasi setiap tenant untuk menghitung total
        Tenant::where('status', true)->each(function (Tenant $tenant) use (&$totalPasien, &$totalDokter) {
            $tenant->execute(function () use (&$totalPasien, &$totalDokter) {
                // Kode ini berjalan di database tenant
                $totalPasien += \App\Models\Pasien::count();
                $totalDokter += \App\Models\Dokter::count();
            });
        });

        // 4. Kirim SEMUA variabel yang dibutuhkan ke view
        return view('domain.admin.dashboard', compact(
            'daftarRumahSakit',
            'totalPasien',
            'totalDokter'
        ));
    }

    /**
     * Menyimpan rumah sakit baru.
     */
    // File: app/Domain/Admin/Http/Controllers/SuperAdminController.php

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|alpha_dash|unique:tenants,domain',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
        ]);

        $fullDomain = $validated['domain'] . '.' . config('app.domain', 'rumahsakit.test');
        $logoPath = $request->hasFile('logo') ? $request->file('logo')->store('public/logos') : null;
        $dbName = 'tenant_' . $validated['domain'];

        // 1. Buat database secara manual terlebih dahulu
        try {
            DB::connection('landlord')->statement("CREATE DATABASE IF NOT EXISTS `$dbName`");
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat database: ' . $e->getMessage())->withInput();
        }

        // 2. Setelah database berhasil dibuat, baru buat record tenant
        RumahSakit::create([
            'name' => $validated['name'],
            'domain' => $fullDomain,
            'logo' => $logoPath,
            'status' => $validated['status'],
            'database' => $dbName,
        ]);

        return redirect()->route('superadmin.dashboard')->with('success', 'Rumah Sakit dan databasenya berhasil dibuat!');
    }


    /**
     * Menampilkan halaman untuk mengedit data rumah sakit.
     */
    public function edit($id)
    {
        $rumahSakit = RumahSakit::findOrFail($id);
        // Kita bisa membuat view baru 'domain.admin.edit' atau memunculkan modal di dashboard
        // Untuk saat ini, kita akan lempar data ke view yang sama untuk di-handle oleh modal
        return view('domain.admin.edit', compact('rumahSakit'));
    }

    /**
     * Memperbarui data rumah sakit.
     */
    public function update(Request $request, $id)
    {
        $rumahSakit = RumahSakit::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|alpha_dash', // unique check di-handle terpisah
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|boolean',
        ]);

        $fullDomain = $validated['domain'] . '.' . config('app.domain', 'rumahsakit.test');

        // Pastikan domain baru unik, kecuali untuk dirinya sendiri
        if ($fullDomain !== $rumahSakit->domain && RumahSakit::where('domain', $fullDomain)->exists()) {
            return back()->withErrors(['domain' => 'Domain sudah digunakan.'])->withInput();
        }

        $dataToUpdate = [
            'name' => $validated['name'],
            'domain' => $fullDomain,
            'status' => $validated['status'],
        ];

        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($rumahSakit->logo) {
                Storage::delete($rumahSakit->logo);
            }
            // Simpan logo baru
            $dataToUpdate['logo'] = $request->file('logo')->store('public/logos');
        }

        $rumahSakit->update($dataToUpdate);

        return redirect()->route('superadmin.dashboard')->with('success', 'Data Rumah Sakit berhasil diperbarui.');
    }

    /**
     * Menghapus rumah sakit.
     */
    public function destroy($id)
    {
        $rumahSakit = RumahSakit::findOrFail($id);
        $dbName = $rumahSakit->database;

        // Hapus record dari tabel tenants
        $rumahSakit->delete();

        // Hapus database fisiknya
        DB::connection('landlord')->statement("DROP DATABASE IF EXISTS `$dbName`");

        return redirect()->route('superadmin.dashboard')->with('success', 'Rumah Sakit dan databasenya berhasil dihapus.');
    }
}