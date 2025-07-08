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
            $table->foreignId('pelaku_usaha_id')->constrained('pelaku_usaha')->onDelete('cascade');
            $table->double('omzet')->nullable();
            $table->string('volume_per_tahun')->nullable();
            $table->integer('jumlah_tenaga_kerja')->nullable();
            $table->string('jangkauan_pemasaran')->nullable();
            $table->string('link_dokumen')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi');
    }
};
