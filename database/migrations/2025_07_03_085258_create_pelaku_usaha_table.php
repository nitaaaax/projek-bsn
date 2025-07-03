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
       Schema::create('pelaku_usaha', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelaku', 100);
            $table->string('produk', 100);
            $table->string('klasifikasi', 50);
            $table->string('status', 50);
            $table->string('provinsi', 100);
            $table->timestamps(); // opsional
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaku_usaha');
    }
};
