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
    Schema::table('tahap2', function (Blueprint $table) {
        $table->text('instansi')->nullable();
        $table->text('sertifikat')->nullable();
    });
}

public function down()
{
    Schema::table('tahap2', function (Blueprint $table) {
        $table->dropColumn(['instansi', 'sertifikat']);
    });
}

};
