<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Dokter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SlotWaktuController extends Controller
{
    /**
     * Menghitung dan mengembalikan slot waktu yang tersedia untuk seorang dokter pada tanggal tertentu.
     */
    public function getAvailableSlots(Request $request, $dokterId, $tanggal): JsonResponse
    {
        try {
            $dokter = Dokter::findOrFail($dokterId);
            $selectedDate = Carbon::parse($tanggal);

            // 1. Ambil semua janji temu yang sudah ada untuk dokter & tanggal tersebut
            $existingAppointments = Appointment::where('dokter_id', $dokterId)
                ->whereDate('tanggal_kunjungan', $selectedDate)
                ->pluck('jam_kunjungan')
                ->map(function ($time) {
                    return Carbon::parse($time)->format('H:i');
                })
                ->toArray();

            // 2. Buat semua kemungkinan slot berdasarkan jadwal dokter
            $availableSlots = [];
            $startTime = Carbon::parse($dokter->jam_mulai);
            $endTime = Carbon::parse($dokter->jam_selesai);
            $duration = $dokter->durasi_konsultasi;

            while ($startTime < $endTime) {
                $slot = $startTime->format('H:i');
                // 3. Hanya tambahkan slot jika BELUM ada di dalam janji temu yang sudah ada
                if (!in_array($slot, $existingAppointments)) {
                    $availableSlots[] = $slot;
                }
                $startTime->addMinutes($duration);
            }

            return response()->json($availableSlots);

        } catch (\Exception $e) {
            // Jika terjadi error (misal: dokter tidak ditemukan), kembalikan array kosong.
            return response()->json([], 500);
        }
    }
}
