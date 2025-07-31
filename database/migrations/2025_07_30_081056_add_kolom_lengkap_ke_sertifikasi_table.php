<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sertifikasi', function (Blueprint $table) {
            if (!Schema::hasColumn('sertifikasi', 'pelaku_usaha_id')) {
                $table->unsignedBigInteger('pelaku_usaha_id')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'nama_pelaku')) {
                $table->string('nama_pelaku')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'klasifikasi')) {
                $table->string('klasifikasi')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'pembina_2')) {
                $table->string('pembina_2')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'sinergi')) {
                $table->string('sinergi')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'nama_kontak_person')) {
                $table->string('nama_kontak_person')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'no_hp')) {
                $table->string('no_hp')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'bulan_pertama_pembinaan')) {
                $table->string('bulan_pertama_pembinaan')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'tahun_dibina')) {
                $table->string('tahun_dibina')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'riwayat_pembinaan')) {
                $table->text('riwayat_pembinaan')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'status_pembinaan')) {
                $table->string('status_pembinaan')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'email')) {
                $table->string('email')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'media_sosial')) {
                $table->string('media_sosial')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'nama_merek')) {
                $table->string('nama_merek')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'omzet')) {
                $table->decimal('omzet', 20, 2)->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'volume_per_tahun')) {
                $table->integer('volume_per_tahun')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'jumlah_tenaga_kerja')) {
                $table->integer('jumlah_tenaga_kerja')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'jangkauan_pemasaran')) {
                $table->json('jangkauan_pemasaran')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'link_dokumen')) {
                $table->string('link_dokumen')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'alamat_kantor')) {
                $table->string('alamat_kantor')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'provinsi_kantor')) {
                $table->string('provinsi_kantor')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'kota_kantor')) {
                $table->string('kota_kantor')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'alamat_pabrik')) {
                $table->string('alamat_pabrik')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'provinsi_pabrik')) {
                $table->string('provinsi_pabrik')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'kota_pabrik')) {
                $table->string('kota_pabrik')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'legalitas_usaha')) {
                $table->string('legalitas_usaha')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'tahun_pendirian')) {
                $table->string('tahun_pendirian')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'foto_produk')) {
                $table->json('foto_produk')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'foto_tempat_produksi')) {
                $table->json('foto_tempat_produksi')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'jenis_usaha')) {
                $table->string('jenis_usaha')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'sni_yang_akan_diterapkan')) {
                $table->string('sni_yang_akan_diterapkan')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'lspro')) {
                $table->string('lspro')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'tanda_daftar_merek')) {
                $table->json('tanda_daftar_merek')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'instansi')) {
                $table->string('instansi')->nullable();
            }

            if (!Schema::hasColumn('sertifikasi', 'sertifikat')) {
                $table->string('sertifikat')->nullable();
            }
        });
    }

    public function down(): void
    {
        // Biarkan kosong atau isi dropColumn seperti sebelumnya jika perlu rollback
    }
};