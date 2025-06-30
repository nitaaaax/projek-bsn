<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpjsTable extends Migration
{
    public function up(): void
    {
        Schema::create('spjs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_spj');
            $table->string('item');
            $table->bigInteger('nominal');
            $table->enum('pembayaran', ['Sudah', 'Belum']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spjs');
    }
}
