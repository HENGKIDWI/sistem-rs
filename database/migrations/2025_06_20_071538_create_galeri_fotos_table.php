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
        Schema::create('galeri_fotos', function (Blueprint $table) {
            $table->id(); // Kolom ID utama

            // Kolom untuk menghubungkan ke rumah sakit (tenant)
            $table->foreignId('tenant_id')
                  ->constrained('rumah_sakits') // Terhubung ke tabel 'rumah_sakits'
                  ->onDelete('cascade');     // Jika RS dihapus, foto ikut terhapus

            // Kolom untuk menyimpan path/lokasi file gambar
            $table->string('foto_path');

            // Kolom untuk judul foto, boleh kosong
            $table->string('judul')->nullable();

            // Kolom untuk deskripsi foto, boleh kosong
            $table->text('deskripsi')->nullable();

            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeri_fotos');
    }
};