<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('usaha', function (Blueprint $table) {
        $table->string('tanda_daftar_merk')->nullable();
    });
}

public function down()
{
    Schema::table('usaha', function (Blueprint $table) {
        $table->dropColumn('tanda_daftar_merk');
    });
}

};
