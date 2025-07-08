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
       Schema::create('riwayat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelaku_usaha_id')->constrained('pelaku_usaha')->onDelete('cascade');
            $table->string('tahun_dibina')->nullable();
            $table->text('riwayat_pembinaan')->nullable();
            $table->string('gruping')->nullable();
            $table->string('email')->nullable();
            $table->string('media_sosial')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat');
    }
};
