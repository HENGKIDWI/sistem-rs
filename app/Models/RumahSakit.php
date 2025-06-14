<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// Hapus atau ganti 'use Illuminate\Database\Eloquent\Model;' dengan baris di bawah
use Spatie\Multitenancy\Models\Tenant;

class RumahSakit extends Tenant // <-- UBAH BAGIAN INI
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'domain',
    ];
}