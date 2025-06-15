<?php

namespace App\Domain\Tenant\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Menampilkan form untuk edit profil.
     */
    public function edit()
    {
        // Ambil data user yang sedang login
        $user = Auth::user();

        // Tampilkan view dan kirim data user ke dalamnya
        return view('domain.tenant.pasien.profile.edit', compact('user'));
    }

    /**
     * Memperbarui data profil di database.
     */
    public function update(Request $request)
    {
        
        // Ambil user yang sedang login
        $user = Auth::user();

        // Validasi data yang masuk
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'ktp_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Validasi file
            'receives_promotions' => ['nullable', 'boolean'], // validasi untuk checkbox
        ]);

        // Update data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'receives_promotions' => $request->boolean('receives_promotions'),
        ]);

                if ($request->hasFile('ktp_file')) {
            // Simpan file ke storage dan dapatkan path-nya
            $path = $request->file('ktp_file')->store('ktp_images', 'public');

            // Simpan path file ke database
            if ($pasien) {
                $pasien->update(['ktp_path' => $path]);
            }
        }

        // Kembali ke halaman edit dengan pesan sukses
        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }
}