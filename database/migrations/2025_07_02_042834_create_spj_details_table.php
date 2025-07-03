<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('spj_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spj_id')->constrained('spj')->onDelete('cascade');
            $table->string('item');
            $table->integer('nominal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spj_details');
    }
};

