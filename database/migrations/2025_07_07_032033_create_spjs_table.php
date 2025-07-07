<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('spjs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_spj');
            $table->text('keterangan')->nullable(); // sesuai model
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spjs');
    }
};
