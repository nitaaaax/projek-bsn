<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('produksi', function (Blueprint $table) {
        $table->string('foto_produk')->nullable();
        $table->string('foto_tempat_produksi')->nullable();
    });
}

public function down()
{
    Schema::table('produksi', function (Blueprint $table) {
        $table->dropColumn(['foto_produk', 'foto_tempat_produksi']);
    });
}

};
