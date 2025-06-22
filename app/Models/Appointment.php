<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'dokter_id',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'keluhan',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'jam_kunjungan' => 'datetime:H:i',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class);
    }

    /**
     * Mendefinisikan relasi one-to-one ke model MedicalRecord.
     */
    public function medicalRecord(): HasOne
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function rujukan(): HasOne
    {
        return $this->hasOne(Rujukan::class);
    }

    // --- LOCAL SCOPES (untuk query yang lebih bersih di controller) ---

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal_kunjungan', today());
    }

    public function scopeMendatang($query)
    {
        return $query->where('status', 'dijadwalkan')
                      ->orderBy('tanggal_kunjungan', 'asc')
                      ->orderBy('jam_kunjungan', 'asc');
    }

    public function scopeRiwayat($query)
    {
        return $query->whereIn('status', ['selesai', 'dibatalkan'])
                      ->orderBy('tanggal_kunjungan', 'desc');
    }

    public function scopeBulanIni($query)
    {
        return $query->whereYear('tanggal_kunjungan', today()->year)
                      ->whereMonth('tanggal_kunjungan', today()->month);
    }
}