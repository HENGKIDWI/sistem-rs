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
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();

            // Kolom untuk menghubungkan ke rumah sakit (tenant)
            $table->foreignId('tenant_id')
                  ->constrained('rumah_sakits') // Terhubung ke tabel 'rumah_sakits'
                  ->onDelete('cascade');     // Jika RS dihapus, fasilitasnya ikut terhapus

            // Kolom untuk nama fasilitas
            $table->string('nama');

            // Kolom untuk ikon (opsional)
            $table->string('icon')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};