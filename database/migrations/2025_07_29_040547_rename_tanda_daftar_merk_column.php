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
    Schema::table('tahap1', function (Blueprint $table) {
        $table->renameColumn('tanda_daftar_merk', 'tanda_daftar_merek');
    });
}

public function down()
{
    Schema::table('tahap1', function (Blueprint $table) {
        $table->renameColumn('tanda_daftar_merek', 'tanda_daftar_merk');
    });
}

    /**
     * Reverse the migrations.
     */
   
};
