<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddTenantIdToKunjungansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Tambahkan kolom hanya jika belum ada
        if (!Schema::hasColumn('kunjungans', 'tenant_id')) {
            Schema::table('kunjungans', function (Blueprint $table) {
                $table->foreignId('tenant_id')->after('id')->nullable();
            });
        }

        // Tambahkan foreign key hanya jika belum ada dan tabel tenants ada
        if (Schema::hasTable('tenants')) {
            // Cek apakah foreign key sudah ada
            $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = 'kunjungans' 
                AND COLUMN_NAME = 'tenant_id' 
                AND CONSTRAINT_NAME <> 'PRIMARY'
            ");

            if (empty($foreignKeys)) {
                Schema::table('kunjungans', function (Blueprint $table) {
                    $table->foreign('tenant_id')
                          ->references('id')
                          ->on('tenants')
                          ->onDelete('cascade');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Hapus foreign key jika ada
        Schema::table('kunjungans', function (Blueprint $table) {
            // Dapatkan nama foreign key
            $foreignKey = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = 'kunjungans' 
                AND COLUMN_NAME = 'tenant_id' 
                AND CONSTRAINT_NAME <> 'PRIMARY'
                AND REFERENCED_TABLE_NAME IS NOT NULL
            ");

            if (!empty($foreignKey)) {
                $keyName = $foreignKey[0]->CONSTRAINT_NAME;
                $table->dropForeign($keyName);
            }
        });

        // Hapus kolom jika ada
        if (Schema::hasColumn('kunjungans', 'tenant_id')) {
            Schema::table('kunjungans', function (Blueprint $table) {
                $table->dropColumn('tenant_id');
            });
        }
    }
}