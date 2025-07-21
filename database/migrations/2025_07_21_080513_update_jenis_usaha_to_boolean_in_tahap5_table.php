<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::table('usaha', function (Blueprint $table) {
            $table->boolean('jenis_usaha')->nullable()->change(); // ubah dari string ke boolean
        });
    }

    public function down(): void
    {
        Schema::table('usaha', function (Blueprint $table) {
            $table->string('jenis_usaha')->nullable()->change(); // rollback ke string
        });
    }

};
