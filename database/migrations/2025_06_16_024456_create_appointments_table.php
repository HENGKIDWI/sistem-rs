<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained(); // pasien
        $table->foreignId('dokter_id')->constrained('dokters');
        $table->date('tanggal_kunjungan');
        $table->time('jam_kunjungan');
        $table->text('keluhan');
        $table->string('status')->default('pending'); // pending, confirmed, completed, canceled
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
