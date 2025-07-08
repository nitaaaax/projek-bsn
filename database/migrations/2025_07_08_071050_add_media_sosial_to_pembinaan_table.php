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
    Schema::table('pembinaan', function (Blueprint $table) {
        $table->string('media_sosial')->nullable(); // tambahkan kolom media_sosial
    });
}

public function down()
{
    Schema::table('pembinaan', function (Blueprint $table) {
        $table->dropColumn('media_sosial');
    });
}
};
