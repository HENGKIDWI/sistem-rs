<?php

namespace App\Domain\Tenant\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Menampilkan form untuk mengedit profil user.
     */
    public function edit()
    {
        return view('domain.tenant.pasien.profile.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Memperbarui data profil user di database.
     */
    public function update(Request $request)
    {
        $user = $request->user();
        $pasien = $user->pasien;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'ktp_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        $user->fill($request->only('name', 'email'));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Menangani upload foto profil.
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada.
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            // Simpan foto baru dan dapatkan path-nya.
            $user->profile_photo_path = $request->file('photo')->store('profile-photos', 'public');
        }

        $user->save();

        // Menangani upload file KTP.
        if ($pasien && $request->hasFile('ktp_file')) {
            if ($pasien->ktp_path) {
                Storage::disk('public')->delete($pasien->ktp_path);
            }
            $pasien->ktp_path = $request->file('ktp_file')->store('ktp_images', 'public');
            $pasien->save();
        }

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }
}
