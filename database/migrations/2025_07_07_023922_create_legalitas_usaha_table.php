<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('legalitas_usaha', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelaku_usaha_id');
            $table->string('jenis_usaha', 100)->nullable();
            $table->string('nama_merek', 100)->nullable();
            $table->string('legalitas', 100)->nullable();
            $table->year('tahun_pendirian')->nullable();
            $table->boolean('sni')->default(false); // Sesuai radio button form
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('pelaku_usaha_id')
                  ->references('id')
                  ->on('pelaku_usaha')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legalitas_usaha');
    }
};
