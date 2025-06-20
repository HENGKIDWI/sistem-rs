<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nomor_rekam_medis',
        'tanggal_lahir',
        'alamat',
        'nomor_telepon',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}