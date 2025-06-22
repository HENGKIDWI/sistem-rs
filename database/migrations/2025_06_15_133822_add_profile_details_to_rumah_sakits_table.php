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
    Schema::table('rumah_sakits', function (Blueprint $table) {
        $table->text('deskripsi')->nullable()->after('domain');
        $table->string('alamat')->nullable()->after('deskripsi');
        $table->string('telepon')->nullable()->after('alamat');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rumah_sakits', function (Blueprint $table) {
            //
        });
    }
};
