<?php

namespace App\Domain\Tenant\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Notifications\AppointmentCreated;

class PasienController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk pasien.
     */
    public function dashboard(Request $request)
    {
        try {
            $user = Auth::user();
            $pasien = $user->pasien;

            if (!$pasien) {
                return redirect()->route('profile.edit')
                    ->with('warning', 'Silakan lengkapi data profil pasien Anda terlebih dahulu untuk mengakses dashboard.');
            }

            $antrianHariIni = Appointment::forUser($user->id)->hariIni()->first();
            $janjiMendatang = Appointment::forUser($user->id)->mendatang()->take(5)->get();
            $riwayatKunjungan = Appointment::forUser($user->id)->riwayat()->latest('tanggal_kunjungan')->take(5)->get();
            $totalKunjungan = Appointment::forUser($user->id)->count();
            $kunjunganBulanIni = Appointment::forUser($user->id)->bulanIni()->count();
            
            $notifikasi = $user->notifications()->latest()->take(5)->get();

            return view('domain.tenant.pasien.dashboard', [
                'pasien' => $pasien,
                'antrian' => $antrianHariIni,
                'kunjungans' => $janjiMendatang,
                'janjiMendatang' => $janjiMendatang,
                'riwayatKunjungan' => $riwayatKunjungan,
                'totalKunjungan' => $totalKunjungan,
                'kunjunganBulanIni' => $kunjunganBulanIni,
                'notifikasi' => $notifikasi,
                'rumahSakit' => app('currentTenant')->name,
            ]);

        } catch (\Exception $e) {
            Log::error('Error pada Dashboard Pasien: ' . $e->getMessage() . ' - User ID: ' . Auth::id());
            return redirect()->route('landing')->with('error', 'Gagal memuat data dashboard Anda. Silakan coba lagi nanti.');
        }
    }

    /**
     * Menampilkan form untuk membuat janji temu baru.
     */
    public function appointmentForm()
    {
        return view('domain.tenant.pasien.appointment-form', [
            'dokters' => Dokter::orderBy('nama_lengkap')->get(),
            'rumahSakit' => app('currentTenant')->name,
        ]);
    }

    /**
     * Menyimpan data janji temu baru yang dibuat oleh pasien.
     */
    public function storeAppointment(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'dokter_id' => 'required|exists:dokters,id', 
                'tanggal_kunjungan' => 'required|date|after_or_equal:today',
                'jam_kunjungan' => 'required|date_format:H:i',
                'keluhan' => 'required|string|min:10|max:1000',
            ]);

            $user = Auth::user();

            $appointment = Appointment::create([
                'user_id'           => $user->id,
                'dokter_id'         => $validatedData['dokter_id'],
                'tanggal_kunjungan' => $validatedData['tanggal_kunjungan'],
                'jam_kunjungan'     => $validatedData['jam_kunjungan'],
                'keluhan'           => $validatedData['keluhan'],
                'status'            => 'dijadwalkan',
            ]);

            // Kirim notifikasi ke pasien
            $user->notify(new AppointmentCreated($appointment));

            return redirect()->route('pasien.dashboard')->with('success', 'Janji temu Anda telah berhasil dibuat.');

        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Gagal membuat janji temu untuk User ID ' . Auth::id() . ': ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan internal saat membuat janji temu. Silakan hubungi administrasi jika masalah berlanjut.')
                ->withInput();
        }
    }

    /**
     * Menampilkan detail rekam medis untuk satu janji temu.
     */
    public function showMedicalRecord(Appointment $appointment): View
    {
        // Pastikan janji temu ini milik user yang sedang login
        abort_if($appointment->user_id !== Auth::id(), 403, 'Anda tidak memiliki akses ke rekam medis ini.');

        // Pastikan rekam medis sudah ada
        abort_if(!$appointment->medicalRecord, 404, 'Rekam medis tidak ditemukan.');

        return view('domain.tenant.pasien.medical-record-detail', [
            'appointment' => $appointment
        ]);
    }
}