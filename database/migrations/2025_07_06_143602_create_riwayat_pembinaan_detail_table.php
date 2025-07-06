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
    Schema::create('riwayat_pembinaan_detail', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pembinaan_id')->constrained('pelaku_usaha')->onDelete('cascade');
        $table->string('kegiatan');
        $table->date('tanggal')->nullable();
        $table->text('catatan')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_pembinaan', function (Blueprint $table) {
            $table->dropColumn('pembinaan_id');
        });
    }
};
