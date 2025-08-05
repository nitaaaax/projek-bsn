<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDokumenToSpjTable extends Migration
{
    public function up()
    {
        Schema::table('spjs', function (Blueprint $table) {
            $table->string('dokumen')->nullable()->after('keterangan');
        });
    }

    public function down()
    {
        Schema::table('spjs', function (Blueprint $table) {
            $table->dropColumn('dokumen');
        });
    }
}
