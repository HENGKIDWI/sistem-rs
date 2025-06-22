<?php

use Illuminate\Support\Facades\Route;
use Spatie\Multitenancy\Http\Middleware\NeedsTenant;
use Spatie\Multitenancy\Http\Middleware\EnsureValidTenantSession;
use App\Domain\Admin\Http\Controllers\SuperAdminController;
use App\Domain\Tenant\Http\Controllers\AdminRsController;
use App\Domain\Tenant\Http\Controllers\DokterController;
use App\Domain\Tenant\Http\Controllers\PasienController;
use App\Domain\Tenant\Http\Controllers\ProfileController;
use App\Domain\Tenant\Http\Controllers\LandingPageRsController;
use App\Http\Controllers\Domain\Tenant\Http\Controllers\Dokter\MedicalRecordController;
use App\Domain\Landlord\Http\Controllers\LandingPageController;
use App\Http\Controllers\Api\SlotWaktuController;
use Illuminate\Http\Request;
use App\Livewire\Tenant\Admin\Dashboard as AdminDashboard;
use App\Livewire\Tenant\Admin\Dokter\ManageDokters;
use App\Livewire\Tenant\Admin\Pengumuman\ManagePengumumans;
use App\Livewire\Tenant\Admin\User\ManageUsers;
use App\Livewire\Tenant\Admin\Appointment\ManageAppointments;
use App\Livewire\Tenant\Admin\Rujukan\IncomingRujukan;
use App\Livewire\Pasien\PatientRujukan;

/*
|--------------------------------------------------------------------------
| Rute Domain Utama (Landlord)
|--------------------------------------------------------------------------
*/
Route::domain(config('app.domain', 'rumahsakit.test'))->group(function () {
    Route::get('/', [LandingPageController::class, 'index'])->name('landing');
});

/*
|--------------------------------------------------------------------------
| Rute Super Admin (Landlord)
|--------------------------------------------------------------------------
*/
Route::domain('admin.' . config('app.domain', 'rumahsakit.test'))->middleware([
    'auth', 'role:super_admin'
])->group(function () {
    Route::get('/', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
    Route::post('/tenants', [SuperAdminController::class, 'store'])->name('superadmin.tenants.store');
    Route::get('/tenants/{rumahSakit}/edit', [SuperAdminController::class, 'edit'])->name('superadmin.tenants.edit');
    Route::put('/tenants/{rumahSakit}', [SuperAdminController::class, 'update'])->name('superadmin.tenants.update');
    Route::delete('/tenants/{rumahSakit}', [SuperAdminController::class, 'destroy'])->name('superadmin.tenants.destroy');
});

/*
|--------------------------------------------------------------------------
| Rute Tenant (Rumah Sakit)
|--------------------------------------------------------------------------
*/
Route::middleware([
    'web',
    EnsureValidTenantSession::class,
])->group(function () {

    // Landing Page Publik untuk Tenant
    Route::get('/', [LandingPageRsController::class, 'index'])->name('tenant.landing');

    // Rute untuk semua user yang sudah login
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Rute untuk Pasien
    Route::middleware(['auth', 'role:pasien'])->group(function() {
        Route::get('/dashboard', [PasienController::class, 'dashboard'])->name('pasien.dashboard');
        Route::get('/rujukan', PatientRujukan::class)->name('pasien.rujukan');
        
        // Rute untuk MENAMPILKAN halaman form janji temu
        Route::get('/appointment/create', [PasienController::class, 'appointmentForm'])->name('pasien.appointment.form');
    
        // Rute untuk MENYIMPAN data saat form janji temu dikirim
        Route::post('/appointment', [PasienController::class, 'storeAppointment'])->name('pasien.appointment.store');

        // --- RUTE API BARU UNTUK MENDAPATKAN SLOT WAKTU ---
        Route::get('/api/slots/{dokterId}/{tanggal}', [SlotWaktuController::class, 'getAvailableSlots'])->name('api.slots.get');

        // --- RUTE BARU UNTUK MELIHAT DETAIL REKAM MEDIS ---
        Route::get('/medical-record/{appointment}', [PasienController::class, 'showMedicalRecord'])->name('pasien.medical-record.show');
    });

    // Rute untuk Dokter
    Route::prefix('dokter')->name('dokter.')->middleware(['auth', 'role:dokter'])->group(function() {
        Route::get('/', [DokterController::class, 'dashboard'])->name('dashboard');
        Route::get('/rujukan', [DokterController::class, 'showRujukan'])->name('rujukan.show');

        // --- RUTE BARU UNTUK REKAM MEDIS ---
        Route::resource('appointments.medical-records', MedicalRecordController::class)->only(['create', 'store', 'show']);
    });

    // Rute untuk Admin RS
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'can:view-admin-dashboard'])->group(function () {
        Route::get('/', AdminDashboard::class)->name('dashboard');
        // Rujukan Management
        Route::get('/rujukan-masuk', IncomingRujukan::class)->name('rujukan.incoming');
        // Janji Temu Management
        Route::get('/appointments', ManageAppointments::class)->name('appointments.index');
        // User Management
        Route::get('/users', ManageUsers::class)->name('users.index');
        // Dokter Management
        Route::get('/dokter', ManageDokters::class)->name('dokter.index');
        Route::get('/pengumuman', ManagePengumumans::class)->name('pengumuman.index');

    });
});

/*
|--------------------------------------------------------------------------
| Rute Hub Dashboard & Rute Otentikasi
|--------------------------------------------------------------------------
*/
Route::get('/home', function (Request $request) {
    $user = $request->user();

    if ($user->hasRole('super_admin')) {
        return redirect()->route('superadmin.dashboard');
    } elseif ($user->hasRole('admin_rs')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('dokter')) {
        return redirect()->route('dokter.dashboard');
    } elseif ($user->hasRole('pasien')) {
        return redirect()->route('pasien.dashboard');
    }
    
    // Fallback default jika user tidak punya peran sama sekali.
    // Sebaiknya arahkan ke halaman profil untuk melengkapi data,
    // atau ke halaman landing tenant. Untuk sekarang, dashboard pasien cukup aman.
    return redirect()->route('pasien.dashboard');

})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';