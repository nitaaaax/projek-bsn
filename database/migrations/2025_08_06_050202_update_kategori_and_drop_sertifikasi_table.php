<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tambah kolom kategori ke tahap1
        Schema::table('tahap1', function (Blueprint $table) {
            $table->string('kategori')->default('umkm')->after('status_pembinaan');
        });

        // Tambah kolom kategori ke tahap2
        Schema::table('tahap2', function (Blueprint $table) {
            $table->string('kategori')->default('umkm')->after('pelaku_usaha_id');
        });

        // Drop tabel sertifikasi
        Schema::dropIfExists('sertifikasi');
    }

    public function down(): void
    {
        // Rollback: hapus kolom kategori dari tahap1 dan tahap2
        Schema::table('tahap1', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });

        Schema::table('tahap2', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });

        // Rollback: buat ulang tabel sertifikasi (optional, struktur disesuaikan dengan sebelumnya)
        Schema::create('sertifikasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelaku_usaha_id');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('pelaku_usaha_id')->references('id')->on('tahap1')->onDelete('cascade');
        });
    }
};

