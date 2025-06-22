<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dokters', function (Blueprint $table) {
            // Menambahkan kolom 'status' dengan nilai default 'aktif'
            // Anda bisa mengganti 'spesialisasi' dengan nama kolom lain jika ingin posisi kolomnya berbeda
            $table->string('status', 20)->default('aktif')->after('spesialisasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokters', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};