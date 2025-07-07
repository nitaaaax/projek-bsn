<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('legalitas_usaha', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pelaku_usaha_id')
            ->constrained('tahap1')
            ->cascadeOnDelete();

        $table->string('jenis_usaha');
        $table->string('nama_merek')->nullable();
        $table->string('legalitas')->nullable();      // PT, CV, NIB, dll
        $table->year  ('tahun_pendirian')->nullable();
        $table->boolean('sni')->default(false);       // true = sudah SNI

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahap3');
    }
};
