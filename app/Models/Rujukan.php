<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Multitenancy\Models\Concerns\UsesLandlordConnection;

class Rujukan extends Model
{
    use HasFactory, UsesLandlordConnection;

    protected $fillable = [
        'user_id',
        'dokter_id',
        'rs_sumber_id',
        'rs_tujuan_id',
        'alasan_rujukan',
        'catatan_dokter',
        'catatan_balasan',
        'status',
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }

    public function rumahSakitSumber(): BelongsTo
    {
        return $this->belongsTo(RumahSakit::class, 'rs_sumber_id');
    }

    public function rumahSakitTujuan(): BelongsTo
    {
        return $this->belongsTo(RumahSakit::class, 'rs_tujuan_id');
    }
}
