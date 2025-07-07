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
        Schema::create('produksi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pelaku_usaha_id')
            ->constrained('tahap1')
            ->cascadeOnDelete();

        $table->decimal('omzet_per_tahun', 15, 2)->nullable(); // Rp
        $table->integer('volume_produksi')->nullable();        // satuan unit/ton
        $table->integer('tenaga_kerja')->nullable();
        $table->string ('jangkauan_pasar')->nullable();        // lokal, nasional, ekspor

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahap6');
    }
};
