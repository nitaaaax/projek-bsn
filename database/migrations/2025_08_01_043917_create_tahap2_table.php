<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('tahap2');

        Schema::create('tahap2', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelaku_usaha_id');
            $table->string('alamat_kantor')->nullable();
            $table->string('provinsi_kantor')->nullable();
            $table->string('kota_kantor')->nullable();
            $table->string('alamat_pabrik')->nullable();
            $table->string('provinsi_pabrik')->nullable();
            $table->string('kota_pabrik')->nullable();
            $table->string('legalitas_usaha')->nullable();
            $table->integer('tahun_pendirian')->nullable();
            $table->bigInteger('omzet')->nullable();
            $table->bigInteger('volume_per_tahun')->nullable();
            $table->integer('jumlah_tenaga_kerja')->nullable();
            $table->longText('jangkauan_pemasaran')->nullable();
            $table->longText('link_dokumen')->nullable();
            $table->longText('foto_produk')->nullable();
            $table->longText('foto_tempat_produksi')->nullable();
            $table->longText('instansi')->nullable();
            $table->text('sertifikasi')->nullable();
            $table->string('sni_yang_diterapkan')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahap2');
    }
};