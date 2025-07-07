<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('pelaku_usaha', function (Blueprint $table) {
            $table->id();                     
            $table->string('nama_pelaku');    
            $table->string('produk');          
            $table->string('klasifikasi');     
            $table->string('status');          
            $table->string('provinsi');        
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaku_usaha');
    }
};
