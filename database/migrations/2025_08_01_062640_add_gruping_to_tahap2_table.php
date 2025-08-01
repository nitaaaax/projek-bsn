<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGrupingToTahap2Table extends Migration
{
    public function up()
    {
        Schema::table('tahap2', function (Blueprint $table) {
            $table->string('gruping')->nullable()->after('sni_yang_diterapkan');
        });
    }

    public function down()
    {
        Schema::table('tahap2', function (Blueprint $table) {
            $table->dropColumn('gruping');
        });
    }
}
