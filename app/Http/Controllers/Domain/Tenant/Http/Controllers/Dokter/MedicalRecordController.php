<?php

namespace App\Http\Controllers\Domain\Tenant\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Appointment $appointment)
    {
        // Pastikan rekam medis belum ada untuk janji temu ini
        if ($appointment->medicalRecord) {
            return redirect()->route('dokter.dashboard')->with('warning', 'Rekam medis untuk janji temu ini sudah ada.');
        }

        return view('domain.tenant.dokter.medical-record-form', ['appointment' => $appointment]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Appointment $appointment)
    {
        $request->validate([
            'diagnosis' => 'required|string|min:5',
            'resep_obat' => 'required|string|min:5',
            'catatan_dokter' => 'nullable|string',
        ]);

        MedicalRecord::create([
            'appointment_id' => $appointment->id,
            'diagnosis' => $request->diagnosis,
            'resep_obat' => $request->resep_obat,
            'catatan_dokter' => $request->catatan_dokter,
        ]);

        // Ubah status janji temu menjadi 'selesai'
        $appointment->update(['status' => 'selesai']);

        return redirect()->route('dokter.dashboard')->with('success', 'Rekam medis berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment, MedicalRecord $medicalRecord)
    {
        // Otorisasi: Pastikan dokter yang login adalah dokter yang terkait dengan janji temu ini.
        if (Auth::user()->dokter->id !== $appointment->dokter_id) {
            abort(403, 'Anda tidak memiliki akses ke rekam medis ini.');
        }

        return view('domain.tenant.dokter.medical-record-show', [
            'appointment' => $appointment,
            'medicalRecord' => $medicalRecord
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
