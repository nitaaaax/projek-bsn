<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelaku_usaha_id')
                  ->constrained('pelaku_usaha')
                  ->cascadeOnDelete();
            $table->decimal('omzet_per_tahun', 15, 2)->nullable();
            $table->string('volume_produksi', 50)->nullable();
            $table->integer('tenaga_kerja')->nullable();
            $table->string('jangkauan_pasar', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produksi');
    }
};
