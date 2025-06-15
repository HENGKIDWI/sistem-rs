<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// Hapus atau ganti 'use Illuminate\Database\Eloquent\Model;' dengan baris di bawah
use Spatie\Multitenancy\Models\Tenant;

class RumahSakit extends Tenant
{
    use HasFactory;
    protected $connection = 'landlord';
    protected $table = 'tenants';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'domain',
        'logo',
        'status',
        'database',
    ];
}