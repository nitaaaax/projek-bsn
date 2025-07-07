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
        Schema::table('spjs', function (Blueprint $table) {
            // Tambahkan kolom no_ukd dan keterangan umum
            $table->string('no_ukd')->after('nama_spj');
            $table->text('keterangan')->after('no_ukd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spjs', function (Blueprint $table) {
            // Hapus kolom yang ditambahkan
            $table->dropColumn(['no_ukd', 'keterangan']);
        });
    }
};
