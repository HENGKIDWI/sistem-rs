<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama',
        'nomor_rekam_medis',
        'tanggal_lahir',
        'alamat',
        'nomor_telepon',
        'ktp_path',
    ];

    // RELASI
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kunjungans(): HasMany
    {
        return $this->hasMany(Kunjungan::class, 'pasien_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'user_id', 'user_id');
    }
}