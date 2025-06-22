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

        // Janji temu yang belum selesai
        $janjiMendatang = Appointment::where('dokter_id', $dokter->id)
            ->where('status', '!=', 'selesai')
            ->with(['user', 'rujukan'])
            ->orderBy('tanggal_kunjungan', 'asc')
            ->orderBy('jam_kunjungan', 'asc')
            ->get();

        // Riwayat janji temu yang sudah selesai
        $riwayatJanji = Appointment::where('dokter_id', $dokter->id)
            ->where('status', 'selesai')
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