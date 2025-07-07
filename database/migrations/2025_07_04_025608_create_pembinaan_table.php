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
       Schema::create('pembinaan', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pelaku_usaha_id')
            ->constrained('tahap1')
            ->cascadeOnDelete();

        $table->string('bulan_pertama');   // mis. "Januari"
        $table->year  ('tahun_bina');
        $table->string('kegiatan')->nullable();
        $table->string('gruping')->nullable();

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahap4');
    }
};
