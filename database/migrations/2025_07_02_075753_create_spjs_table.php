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
            Schema::create('spjs', function (Blueprint $table) {
        $table->id();
        $table->string('nama_spj');
        $table->string('pembayaran')->nullable();  // Tambahkan kolom ini
        $table->text('keterangan')->nullable();    // Tambahkan kolom ini
        $table->timestamps();
    });

    }
};
