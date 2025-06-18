<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Spatie\Multitenancy\Models\Tenant;

class RumahSakit extends Tenant
{
    use HasFactory;

    protected $connection = 'landlord';
    protected $table = 'tenants';

    protected $fillable = [
        'name',
        'domain',
        'database',
        'logo',
        'status',
    ];

    /**
     * Method untuk memberi tahu nama database tenant (WAJIB untuk spatie/laravel-multitenancy)
     */
    // public function getDatabaseName(): string
    // {
    //     return $this->database;
    // }

    // protected static function booted(): void
    // {
    //     static::created(function (RumahSakit $tenant) {
    //         // Pastikan database benar-benar dibuat (jika belum)
    //         DB::connection('landlord')->statement("CREATE DATABASE IF NOT EXISTS `{$tenant->database}`");

    //         // Jalankan migrasi dan seeding tenant
    //         Artisan::call('tenants:artisan', [
    //             'artisanCommand' => 'migrate --database=tenant --seed --force',
    //             '--tenant' => $tenant->id,
    //         ]);
    //     });
    // }
}
