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
            $table->string('nama_pelaku')->nullable();
            $table->string('produk')->nullable();
            $table->string('klasifikasi')->nullable();
            $table->string('status')->nullable();
            $table->string('pembina_1')->nullable();
            $table->timestamps();
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
