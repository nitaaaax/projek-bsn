<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sertifikasi', function (Blueprint $table) {
            $table->id();

            // Relasi ke tahap1 dan tahap2
            $table->unsignedBigInteger('tahap1_id')->nullable();
            $table->unsignedBigInteger('tahap2_id')->nullable();

            // Kolom-kolom lain
            $table->string('nama_pelaku')->nullable();
            $table->string('produk')->nullable();
            $table->string('klasifikasi')->nullable();
            $table->string('status', 50)->nullable();
            $table->string('pembina_1')->nullable();
            $table->string('pembina_2')->nullable();
            $table->string('sinergi')->nullable();
            $table->string('nama_kontak_person')->nullable();
            $table->string('no_hp', 25)->nullable();
            $table->string('bulan_pertama_pembinaan', 10);
            $table->string('tahun_dibina', 4)->nullable();
            $table->text('riwayat_pembinaan')->nullable();
            $table->string('status_pembinaan', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('media_sosial')->nullable();
            $table->string('nama_merek')->nullable();
            $table->enum('jenis_usaha', ['Pangan', 'Nonpangan'])->nullable();
            $table->string('lspro')->nullable();
            $table->string('tanda_daftar_merk')->nullable();
            $table->string('alamat_kantor')->nullable();
            $table->string('provinsi_kantor')->nullable();
            $table->string('kota_kantor')->nullable();
            $table->string('alamat_pabrik')->nullable();
            $table->string('provinsi_pabrik')->nullable();
            $table->string('kota_pabrik')->nullable();
            $table->string('legalitas_usaha')->nullable();
            $table->string('tahun_pendirian', 4)->nullable();
            $table->bigInteger('omzet')->nullable();
            $table->bigInteger('volume_per_tahun')->nullable();
            $table->integer('jumlah_tenaga_kerja')->nullable();
            $table->longText('jangkauan_pemasaran')->nullable();
            $table->string('link_dokumen')->nullable();
            $table->longText('foto_produk')->nullable();
            $table->longText('foto_tempat_produksi')->nullable();
            $table->longText('instansi')->nullable();
            $table->longText('sertifikat')->nullable();
            $table->longText('sni_yang_diterapkan')->nullable();
            $table->string('gruping')->nullable();

            $table->timestamps();

            // Pastikan foreign key valid
            $table->foreign('tahap1_id')->references('id')->on('tahap1')->onDelete('set null');
            $table->foreign('tahap2_id')->references('pelaku_usaha_id')->on('tahap2')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikasi');
    }
};
