<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rumah_sakits', function (Blueprint $table) {
            // Menambahkan kolom setelah kolom 'telepon'
            $table->string('logo_url')->nullable()->after('telepon');
            $table->string('jam_operasional')->nullable()->after('logo_url');
        });
    }

    public function down(): void
    {
        Schema::table('rumah_sakits', function (Blueprint $table) {
            $table->dropColumn(['logo_url', 'jam_operasional']);
        });
    }
};