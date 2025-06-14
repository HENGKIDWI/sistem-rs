<?php

use Illuminate\Support\Facades\Route;
use Spatie\Multitenancy\Http\Middleware\NeedsTenant;
use Spatie\Multitenancy\Http\Middleware\EnsureValidTenantSession;
use Spatie\Multitenancy\Contracts\IsTenant;

// Grup ini memastikan rute di dalamnya hanya cocok untuk domain utama.
Route::domain(config('app.domain', 'rumahsakit.test'))->group(function () {
    
    // Halaman utama, nanti bisa menampilkan daftar rumah sakit.
    Route::get('/', function () {
        // Contoh: Ambil semua data RS untuk ditampilkan di landing page.
        // $rumahSakits = \App\Models\RumahSakit::all();
        // return view('welcome', ['rumahSakits' => $rumahSakits]);
        
        return 'Ini adalah Landing Page Utama. Daftar RS akan muncul di sini.';
    });

});

Route::domain('admin.' . config('app.domain', 'rumahsakit.test'))->group(function () {
    // Rute untuk Super Admin akan diarahkan ke Panel Filament-nya.
    // Untuk sementara, kita bisa buat rute tes.
    Route::get('/', function () {
        return 'Redirecting to Super Admin Panel...';
    });
});

/*
|--------------------------------------------------------------------------
| Rute Subdomain Rumah Sakit (Tenant)
|--------------------------------------------------------------------------
|
| Rute-rute di bawah ini akan aktif untuk SEMUA subdomain yang valid
| (misalnya: rsharapan.rumahsakit.test, rsmitra.rumahsakit.test, dll).
| Middleware `NeedsTenant` secara otomatis akan mencari dan menetapkan
| rumah sakit yang aktif berdasarkan subdomain.
|
*/
Route::middleware([
    'web',
    NeedsTenant::class,
    EnsureValidTenantSession::class,
])->group(function () {

    Route::get('/', function () {
        // Ambil tenant yang aktif dari container
        $currentTenant = app(IsTenant::class);

        // Jika tenant ditemukan, tampilkan namanya. Jika tidak, beri pesan fallback.
        return 'Selamat datang di Portal Pasien: ' . ($currentTenant ? $currentTenant->name : 'Unknown');
    });

    Route::get('/dokter', function() {
        $currentTenant = app(IsTenant::class);
        return 'Ini adalah Dashboard untuk Dokter di ' . ($currentTenant ? $currentTenant->name : 'Unknown');
    });

    Route::get('/admin', function() {
        $currentTenant = app(IsTenant::class);
        return 'Ini adalah Panel untuk Admin RS ' . ($currentTenant ? $currentTenant->name : 'Unknown');
    });

});