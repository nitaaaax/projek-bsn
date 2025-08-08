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
        // Cek dulu apakah kolom sudah ada atau belum
        if (!Schema::hasColumn('spjs', 'lembaga_sertifikasi')) {
            Schema::table('spjs', function (Blueprint $table) {
                $table->string('lembaga_sertifikasi', 255)
                      ->nullable()
                      ->after('no_ukd')
                      ->comment('Nama lembaga sertifikasi');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        if (Schema::hasColumn('spjs', 'lembaga_sertifikasi')) {
            Schema::table('spjs', function (Blueprint $table) {
                $table->dropColumn('lembaga_sertifikasi');
            });
        }
    }
};