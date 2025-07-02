<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpjDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('spj_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spj_id')->constrained('spjs')->onDelete('cascade');
            $table->string('item');
            $table->integer('nominal');
            $table->enum('status_pembayaran', ['sudah_dibayar', 'belum_dibayar']);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spj_details');
    }
}
