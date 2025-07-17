<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('usaha', function (Blueprint $table) {
        $table->boolean('tanda_daftar_merk')->default(0)->change();
    });
}

public function down()
{
    Schema::table('usaha', function (Blueprint $table) {
        $table->string('tanda_daftar_merk')->nullable()->change(); // jika sebelumnya string
    });
}

};
