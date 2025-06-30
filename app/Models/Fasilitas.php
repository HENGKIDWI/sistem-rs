<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    // Menggunakan trait standar dari Laravel.
    // Trait untuk multi-tenancy tidak diperlukan di sini karena
    // kita sudah mengaturnya secara global melalui ApplyTenantScopeTask.
    use HasFactory;

    /**
     * Nama tabel database yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'fasilitas';

    /**
     * Atribut yang diizinkan untuk diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'nama',
        'icon',
    ];

    /**
     * Mendefinisikan relasi "milik" (belongsTo) ke model RumahSakit.
     */
    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class, 'tenant_id');
    }

    protected static function booted()
    {
        static::creating(function ($fasilitas) {
            if (empty($fasilitas->tenant_id) && app()->bound('currentTenant')) {
                $fasilitas->tenant_id = app('currentTenant')->id;
            }
        });
    }
}
