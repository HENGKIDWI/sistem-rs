<?php

namespace App\Domain\Tenant\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DokterController extends Controller
{
    /**
     * Menampilkan halaman dashboard untuk Dokter.
     */
    public function dashboard(): View
    {
        $dokter = Auth::user()->dokter;

        // Mengambil janji temu berdasarkan statusnya, bukan hanya tanggal.
        // Ini lebih akurat karena dokter mungkin perlu mengisi rekam medis di hari yang sama.
        $janjiMendatang = Appointment::where('dokter_id', $dokter->id)
            ->where('tanggal_kunjungan', '>=', now()->toDateString())
            ->where(function ($query) {
                $query->where('tanggal_kunjungan', '>', now()->toDateString())
                      ->orWhere(function ($query) {
                          $query->where('tanggal_kunjungan', now()->toDateString())
                                ->where('jam_kunjungan', '>=', now()->toTimeString());
                      });
            })
            ->with(['user', 'rujukan'])
            ->orderBy('tanggal_kunjungan', 'asc')
            ->orderBy('jam_kunjungan', 'asc')
            ->get();

        $riwayatJanji = Appointment::where('dokter_id', $dokter->id)
            ->where('tanggal_kunjungan', '<', now()->toDateString())
            ->with(['user', 'medicalRecord'])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('jam_kunjungan', 'desc')
            ->paginate(5);

        return view('domain.tenant.dokter.dashboard', [
            'janjiMendatang' => $janjiMendatang,
            'riwayatJanji' => $riwayatJanji,
        ]);
    }

    /**
     * Menampilkan halaman rujukan untuk Dokter.
     */
    public function showRujukan(): View
    {
        // TODO: Tambahkan logika untuk menampilkan data rujukan
        return view('domain.tenant.dokter.rujukan');
    }
}