<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeJenisUsahaToStringInTahap2Table extends Migration
{
  public function up()
{
    Schema::table('tahap2', function (Blueprint $table) {
        $table->string('jenis_usaha')->nullable(); // tambahkan kolom baru
    });
}

public function down()
{
    Schema::table('tahap2', function (Blueprint $table) {
        $table->dropColumn('jenis_usaha');
    });
}

}