<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Dokter extends Model
{
    use HasFactory;

    /**
     * Menonaktifkan mass assignment guard.
     * Alternatif dari penggunaan $fillable.
     * @var array
     */
    protected $guarded = [];

    /**
     * Mendefinisikan relasi "milik dari" ke model RumahSakit.
     * Ini adalah relasi yang dibutuhkan oleh Filament untuk scoping tenant.
     */
    public function rumahSakit(): BelongsTo
    {
        return $this->belongsTo(RumahSakit::class, 'tenant_id');
    }

    /**
     * Mendefinisikan relasi ke model User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi ke model Kunjungan.
     */
    public function kunjungans()
    {
        return $this->hasMany(Kunjungan::class);
    }

    /**
     * Accessor untuk mendapatkan URL lengkap dari foto dokter.
     * Membuat atribut virtual {{ $dokter->foto_url }} yang bisa dipakai di Blade.
     */
    public function getFotoUrlAttribute()
    {
        // Cek jika ada path foto yang tersimpan
        if ($this->foto_path && Storage::disk('public')->exists($this->foto_path)) {
            // Buat URL publik yang bisa diakses browser
            return Storage::url($this->foto_path);
        }

        // Jika tidak ada foto, kembalikan gambar placeholder dari UI Avatars
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama_lengkap) . '&color=7F9CF5&background=EBF4FF';
    }
}