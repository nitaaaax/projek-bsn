<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeJenisUsahaToStringInTahap1Table extends Migration
{
    public function up()
    {
        Schema::table('tahap1', function (Blueprint $table) {
            $table->string('jenis_usaha')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('tahap1', function (Blueprint $table) {
            $table->boolean('jenis_usaha')->default(0)->change();
        });
    }
}