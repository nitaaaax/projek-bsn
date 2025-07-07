<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('riwayat_pembinaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('riwayat_pembinaan_id')->constrained('pembinaan')->onDelete('cascade');
            $table->string('kegiatan', 100);
            $table->string('gruping', 100)->nullable();
            $table->date('tanggal');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_pembinaan');
    }
};
