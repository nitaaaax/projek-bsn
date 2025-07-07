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
      Schema::create('riwayat_pembinaan_detail', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pembinaan_id')
            ->constrained('tahap4')
            ->cascadeOnDelete();

        $table->string ('kegiatan');
        $table->string ('gruping')->nullable();
        $table->date   ('tanggal');
        $table->text   ('catatan')->nullable();

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahap5');
    }
};
