<?php

use Illuminate\Support\Facades\Route;
use Spatie\Multitenancy\Http\Middleware\NeedsTenant;
use Spatie\Multitenancy\Http\Middleware\EnsureValidTenantSession;
use App\Domain\Admin\Http\Controllers\SuperAdminController;
use App\Domain\Tenant\Http\Controllers\AdminRsController;
use App\Domain\Tenant\Http\Controllers\DokterController;
use App\Domain\Tenant\Http\Controllers\PasienController;
use app\Domain\Landlord\Http\Controllers\LandingPageController;
use Illuminate\Http\Request; 


/*
|--------------------------------------------------------------------------
| Rute Domain Utama (Landlord)
|--------------------------------------------------------------------------
*/

// Domain Utama (rumahsakit.test)
Route::domain(config('app.domain', 'rumahsakit.test'))->group(function () {
    Route::get('/', [LandingPageController::class, 'index'])->name('landing');
});

// Domain Super Admin (admin.rumahsakit.test)
Route::domain('admin.' . config('app.domain', 'rumahsakit.test'))->middleware([
    'auth', 'role:super_admin'
])->group(function () {
    Route::get('/', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
});


/*
|--------------------------------------------------------------------------
| Rute Subdomain Rumah Sakit (Tenant)
|--------------------------------------------------------------------------
*/
Route::middleware([
    'web',
    NeedsTenant::class,
    EnsureValidTenantSession::class,
])->group(function () {

    // Rute untuk Pasien
    Route::middleware(['auth', 'role:pasien'])->group(function() {
        Route::get('/', [PasienController::class, 'dashboard'])->name('pasien.dashboard');
    });

    // Rute untuk Dokter
    Route::prefix('dokter')->name('dokter.')->middleware(['auth', 'role:dokter'])->group(function() {
        Route::get('/', [DokterController::class, 'dashboard'])->name('dashboard');
        Route::get('/rujukan', [DokterController::class, 'showRujukan'])->name('rujukan.show');
    });

    // Rute untuk Admin RS
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin_rs'])->group(function() {
        Route::get('/', [AdminRsController::class, 'dashboard'])->name('dashboard');
        Route::get('/kelola-dokter', [AdminRsController::class, 'manageDokter'])->name('dokter.manage');
    });

});

/*
|--------------------------------------------------------------------------
| Rute "Hub" Dashboard
|--------------------------------------------------------------------------
| Rute ini akan menjadi titik masuk setelah login, yang kemudian akan
| mengarahkan pengguna ke dashboard yang sesuai dengan perannya.
*/
Route::get('/dashboard', function (Request $request) {
    /** @var \App\Models\User $user */
    $user = $request->user();

    if ($user->hasRole('super_admin')) {
        return redirect()->route('superadmin.dashboard');
    }

    if ($user->hasRole('admin_rs')) {
        // Pastikan Anda berada di domain tenant yang benar atau tangani logikanya
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('dokter')) {
        // Pastikan Anda berada di domain tenant yang benar atau tangani logikanya
        return redirect()->route('dokter.dashboard');
    }

    if ($user->hasRole('pasien')) {
        // Pastikan Anda berada di domain tenant yang benar atau tangani logikanya
        return redirect()->route('pasien.dashboard');
    }

    // Fallback jika user tidak punya peran yang dikenali
    return redirect('/');

})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';