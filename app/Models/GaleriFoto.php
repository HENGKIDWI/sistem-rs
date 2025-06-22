<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GaleriFoto extends Model
{
    // Menggunakan trait standar untuk factory dari Laravel
    use HasFactory;

    /**
     * Nama tabel database yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'galeri_fotos';

    /**
     * Atribut yang diizinkan untuk diisi secara massal (mass assignment).
     * Ini adalah daftar kolom yang aman untuk diisi melalui metode create() atau update().
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'foto_path',
        'judul',
        'deskripsi',
    ];

    /**
     * Mendefinisikan relasi "milik" (belongsTo) ke model RumahSakit.
     * Ini memberitahu Laravel bahwa setiap foto galeri dimiliki oleh satu RumahSakit (tenant).
     */
    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class, 'tenant_id');
    }

    /**
     * Get the full URL for the foto.
     */
    protected function fotoUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->foto_path ? Storage::url($this->foto_path) : null,
        );
    }
}
