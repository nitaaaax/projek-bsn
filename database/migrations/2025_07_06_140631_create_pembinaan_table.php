<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembinaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelaku_usaha_id')
                  ->constrained('pelaku_usaha')
                  ->cascadeOnDelete();
            $table->tinyInteger('bulan_pertama')->nullable(); // 1–12
            $table->year('tahun_bina')->nullable();
            $table->string('kegiatan', 100)->nullable();
            $table->string('gruping', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembinaan');
    }
};
