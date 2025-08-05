<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeBulanPertamaNullableInTahap1Table extends Migration
{
    public function up(): void
    {
        Schema::table('tahap1', function (Blueprint $table) {
            $table->string('bulan_pertama_pembinaan')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('tahap1', function (Blueprint $table) {
            $table->string('bulan_pertama_pembinaan')->nullable(false)->change();
        });
    }
}
