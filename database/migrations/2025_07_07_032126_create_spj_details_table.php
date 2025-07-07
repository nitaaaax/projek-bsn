<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('spj_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spj_id')->constrained('spjs')->onDelete('cascade');
            $table->string('item');
            $table->decimal('nominal', 15, 2);
            $table->enum('status_pembayaran', ['belum_dibayar', 'sudah_dibayar'])->default('belum_dibayar');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spj_details');
    }
};
