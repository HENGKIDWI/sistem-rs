<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rumah_sakits', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama lengkap rumah sakit, misal "RS Harapan Sejati"
            $table->string('domain')->unique(); // Subdomain, misal "rsharapan.rumahsakit.test"
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rumah_sakits');
    }
};