<?php

// Test sederhana untuk memeriksa alur login pasien
require_once 'vendor/autoload.php';

use App\Models\User;
use App\Models\Pasien;
use Spatie\Permission\Models\Role;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TEST LOGIN PASIEN ===\n\n";

// 1. Cek apakah ada user
$users = User::all();
echo "Total users: " . $users->count() . "\n";

// 2. Cari user dengan role pasien
$pasienUsers = User::role('pasien')->get();
echo "Users dengan role pasien: " . $pasienUsers->count() . "\n";

if ($pasienUsers->count() > 0) {
    $pasienUser = $pasienUsers->first();
    echo "User pasien pertama: " . $pasienUser->name . " (" . $pasienUser->email . ")\n";
    
    // 3. Cek apakah user punya data pasien
    $pasien = $pasienUser->pasien;
    if ($pasien) {
        echo "Data pasien: " . $pasien->nama . " (RM: " . $pasien->nomor_rekam_medis . ")\n";
    } else {
        echo "User tidak punya data pasien\n";
    }
    
    // 4. Test role checking
    echo "\n=== TEST ROLE CHECKING ===\n";
    echo "hasRole('pasien'): " . ($pasienUser->hasRole('pasien') ? 'YES' : 'NO') . "\n";
    echo "hasRole('admin_rs'): " . ($pasienUser->hasRole('admin_rs') ? 'YES' : 'NO') . "\n";
    echo "hasRole('dokter'): " . ($pasienUser->hasRole('dokter') ? 'YES' : 'NO') . "\n";
    echo "hasRole('super_admin'): " . ($pasienUser->hasRole('super_admin') ? 'YES' : 'NO') . "\n";
    
} else {
    echo "Tidak ada user dengan role pasien\n";
    
    // Cek semua user dan rolenya
    echo "\n=== SEMUA USER DAN ROLE ===\n";
    foreach ($users as $user) {
        echo $user->name . " (" . $user->email . "): " . $user->roles->pluck('name')->implode(', ') . "\n";
    }
}

// 5. Cek roles yang tersedia
echo "\n=== ROLES YANG TERSEDIA ===\n";
$allRoles = Role::all();
foreach ($allRoles as $role) {
    echo "- " . $role->name . "\n";
}

echo "\n=== SELESAI ===\n"; 