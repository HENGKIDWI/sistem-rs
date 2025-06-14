<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekamMedis extends Model
{
    use HasFactory;

    // Nama tabel eksplisit jika berbeda dari penamaan standar
    protected $table = 'rekam_medis';

    protected $guarded = [];

    /**
     * Mendefinisikan relasi: Rekam Medis ini milik sebuah Kunjungan.
     */
    public function kunjungan(): BelongsTo
    {
        return $this->belongsTo(Kunjungan::class);
    }
}