<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Multitenancy\Contracts\IsTenant;

// Impor semua model yang akan direlasikan
use App\Models\Dokter;
use App\Models\Pengumuman;
use App\Models\GaleriFoto;

class RumahSakit extends Tenant implements IsTenant
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
        'deskripsi',
        'alamat',
        'telepon',
        'jam_operasional',
        'logo_url',
    ];

    // --- INI BAGIAN PENTING YANG PERLU DITAMBAHKAN ---
    // Mendefinisikan relasi (jembatan) ke tabel lain.

    /**
     * Relasi: Satu Rumah Sakit memiliki banyak Dokter.
     */
    public function dokters()
    {
        return $this->hasMany(Dokter::class, 'tenant_id');
    }

    /**
     * Relasi: Satu Rumah Sakit memiliki banyak Pengumuman.
     */
    public function pengumumans()
    {
        return $this->hasMany(Pengumuman::class, 'tenant_id');
    }

    /**
     * Relasi: Satu Rumah Sakit memiliki banyak Foto Galeri.
     */
    public function galeriFotos()
    {
        return $this->hasMany(GaleriFoto::class, 'tenant_id');
    }

    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class, 'tenant_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'rumah_sakit_user', 'rumah_sakit_id', 'user_id');
    }
}