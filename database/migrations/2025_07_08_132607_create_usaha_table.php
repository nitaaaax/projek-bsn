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
       Schema::create('tahap5', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelaku_usaha_id')->constrained('pelaku_usaha')->onDelete('cascade');
            $table->string('jenis_usaha')->nullable();
            $table->string('nama_merek')->nullable();
            $table->boolean('sni')->nullable();
            $table->string('lspro')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usaha');
    }
};
