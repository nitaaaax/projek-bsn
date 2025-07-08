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
       Schema::create('alamat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelaku_usaha_id')->constrained('pelaku_usaha')->onDelete('cascade');
            $table->string('alamat')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('legalitas_usaha')->nullable();
            $table->string('tahun_pendirian')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat');
    }
};
