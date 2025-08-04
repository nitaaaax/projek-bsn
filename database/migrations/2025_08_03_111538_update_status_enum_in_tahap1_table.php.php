<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusEnumInTahap1Table extends Migration
{
    public function up(): void
    {
        Schema::table('tahap1', function (Blueprint $table) {
            $table->enum('status', ['masih dibina', 'drop/tidak dilanjutkan'])
                  ->nullable()
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('tahap1', function (Blueprint $table) {
            // Balik ke tipe string biasa, jika dibatalkan
            $table->string('status', 50)->nullable()->change();
        });
    }
}
