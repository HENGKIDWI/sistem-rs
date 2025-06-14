<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermintaanTransfer extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Mendefinisikan relasi: Permintaan ini untuk seorang Pasien.
     */
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    /**
     * Mendefinisikan relasi: Permintaan ini dibuat oleh seorang Dokter (User).
     */
    public function dariDokter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dari_dokter_id');
    }

    /**
     * Mendefinisikan relasi: RS Asal.
     * Note: Ini adalah relasi ke tabel landlord, memerlukan logika khusus jika diakses dari tenant.
     */
    public function dariTenant(): BelongsTo
    {
        return $this->belongsTo(RumahSakit::class, 'dari_tenant_id');
    }

    /**
     * Mendefinisikan relasi: RS Tujuan.
     */
    public function keTenant(): BelongsTo
    {
        return $this->belongsTo(RumahSakit::class, 'ke_tenant_id');
    }
}