<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kunjungan extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi secara massal (mass assignable)
    protected $guarded = [];

    /**
     * Mendefinisikan relasi: Kunjungan ini milik seorang Pasien.
     */
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    /**
     * Mendefinisikan relasi: Kunjungan ini ditangani oleh seorang Dokter (User).
     */
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class);
    }

    /**
     * Mendefinisikan relasi: Kunjungan ini memiliki satu Rekam Medis.
     */
    public function rekamMedis(): HasOne
    {
        return $this->hasOne(RekamMedis::class);
    }
}