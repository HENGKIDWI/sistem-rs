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
        Schema::create('rujukans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->comment('ID Pasien')->constrained('users')->onDelete('cascade');
            $table->foreignId('dokter_id')->comment('ID Dokter Perujuk')->constrained('dokters')->onDelete('cascade');
            $table->foreignId('rs_sumber_id')->comment('ID RS Sumber')->constrained('rumah_sakits')->onDelete('cascade');
            $table->foreignId('rs_tujuan_id')->comment('ID RS Tujuan')->constrained('rumah_sakits')->onDelete('cascade');
            $table->text('alasan_rujukan');
            $table->text('catatan_dokter')->nullable();
            $table->text('catatan_balasan')->nullable();
            $table->string('status')->default('pending_rs_approval'); // pending_rs_approval, pending_patient_approval, approved, rejected_by_rs, cancelled_by_patient
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rujukans');
    }
};
