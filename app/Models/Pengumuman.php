<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengumuman'; // Pastikan nama tabel cocok

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'judul',
        'isi',
        'tanggal',
        'tenant_id', // Penting jika Anda ingin memfilter secara eksplisit per tenant
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal' => 'date', // Otomatis casting ke objek Carbon
    ];

    public function rumahSakit(): BelongsTo
    {
        return $this->belongsTo(RumahSakit::class, 'tenant_id');
    }
}