<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasiens');
            $table->foreignId('dari_dokter_id')->constrained('users');
            $table->string('dari_tenant_id'); // Merujuk ke ID dari tabel tenants (landlord)
            $table->string('ke_tenant_id'); // Merujuk ke ID dari tabel tenants (landlord)
            $table->text('alasan_rujukan');
            $table->string('status')->default('pending_approval');
            $table->text('catatan_balasan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_transfers');
    }
};