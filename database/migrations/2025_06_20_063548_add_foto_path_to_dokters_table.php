<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokters', function (Blueprint $table) {
            // Menambahkan kolom untuk menyimpan path foto setelah kolom spesialisasi
            $table->string('foto_path')->nullable()->after('spesialisasi');
        });
    }

    public function down(): void
    {
        Schema::table('dokters', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn('foto_path');
        });
    }
};