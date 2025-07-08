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
        Schema::create('pembinaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelaku_usaha_id')->constrained('pelaku_usaha')->onDelete('cascade');
            $table->string('pembina_2')->nullable();
            $table->string('sinergi')->nullable();
            $table->string('nama_kontak_person');
            $table->string('No_Hp');
            $table->string('bulan__pertama_pembinaan')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembinaan');
    }
};
