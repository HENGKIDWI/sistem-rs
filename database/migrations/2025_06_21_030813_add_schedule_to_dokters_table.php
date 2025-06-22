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
            $table->time('jam_mulai')->default('09:00:00')->after('status');
            $table->time('jam_selesai')->default('17:00:00')->after('jam_mulai');
            $table->integer('durasi_konsultasi')->default(30)->after('jam_selesai')->comment('Durasi dalam menit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dokters', function (Blueprint $table) {
            $table->dropColumn(['jam_mulai', 'jam_selesai', 'durasi_konsultasi']);
        });
    }
};
