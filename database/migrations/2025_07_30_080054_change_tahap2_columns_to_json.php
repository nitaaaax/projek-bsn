<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tahap2', function (Blueprint $table) {
            $table->json('jangkauan_pemasaran')->nullable()->change();
            $table->json('tanda_daftar_merek')->nullable()->change();
            $table->json('foto_produk')->nullable()->change();
            $table->json('foto_tempat_produksi')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('tahap2', function (Blueprint $table) {
            $table->text('jangkauan_pemasaran')->nullable()->change();
            $table->text('tanda_daftar_merek')->nullable()->change();
            $table->text('foto_produk')->nullable()->change();
            $table->text('foto_tempat_produksi')->nullable()->change();
        });
    }
};