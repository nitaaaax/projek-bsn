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
       Schema::create('kontak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelaku_usaha_id')
                ->constrained('tahap1')
                ->cascadeOnDelete();

            $table->string('nama_kontak');
            $table->string('no_hp', 25);
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
        Schema::dropIfExists('tahap2');
    }
};
