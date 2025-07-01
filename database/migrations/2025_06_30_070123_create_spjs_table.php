<?php

// database/migrations/2024_01_01_000000_create_spj_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpjTable extends Migration
{
    public function up()
    {
        Schema::create('spj', function (Blueprint $table) {
            $table->id();
            $table->string('nama_spj');
            $table->enum('pembayaran', ['Sudah', 'Belum']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spj');
    }
}

// database/migrations/2024_01_01_000001_create_spj_detail_table.php
class CreateSpjDetailTable extends Migration
{
    public function up()
    {
        Schema::create('spj_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spj_id')->constrained('spj')->onDelete('cascade');
            $table->string('item');
            $table->bigInteger('nominal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('spj_detail');
    }
}