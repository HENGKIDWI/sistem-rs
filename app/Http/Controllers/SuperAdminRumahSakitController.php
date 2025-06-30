<?php

namespace App\Http\Controllers;

use App\Models\RumahSakit;
use Illuminate\Http\Request;

class SuperAdminRumahSakitController extends Controller
{
    public function index()
    {
        $rumahSakits = RumahSakit::all();
        return view('superadmin.rumah-sakit.index', compact('rumahSakits'));
    }

    public function edit($id)
    {
        $rumahSakit = RumahSakit::findOrFail($id);
        return view('superadmin.rumah-sakit.edit', compact('rumahSakit'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $rumahSakit = RumahSakit::findOrFail($id);

        $data = $request->only(['name', 'domain', 'alamat', 'deskripsi', 'telepon', 'jam_operasional']);

        if ($request->hasFile('logo_url')) {
            // Hapus logo lama jika ada
            if ($rumahSakit->logo_url) {
                \Storage::disk('public')->delete($rumahSakit->logo_url);
            }
            $data['logo_url'] = $request->file('logo_url')->store('logo-rumah-sakit', 'public');
        }

        $rumahSakit->update($data);

        return redirect()->route('superadmin.rumahsakit.index')->with('success', 'Data berhasil diupdate');
    }

    public function create()
    {
        return view('superadmin.rumah-sakit.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:rumah_sakits,domain',
            'alamat' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'telepon' => 'nullable|string',
            'jam_operasional' => 'nullable|string',
            'logo_url' => 'nullable|file|mimes:jpg,jpeg,png,svg|max:2048',
        ]);
        if ($request->hasFile('logo_url')) {
            $data['logo_url'] = $request->file('logo_url')->store('logo-rumah-sakit', 'public');
        }
        \App\Models\RumahSakit::create($data);
        return redirect()->route('superadmin.rumahsakit.index')->with('success', 'Rumah Sakit berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $rumahSakit = \App\Models\RumahSakit::findOrFail($id);
        // Hapus logo jika ada
        if ($rumahSakit->logo_url) {
            \Storage::disk('public')->delete($rumahSakit->logo_url);
        }
        $rumahSakit->delete();
        return redirect()->route('superadmin.rumahsakit.index')->with('success', 'Rumah Sakit berhasil dihapus');
    }
} 