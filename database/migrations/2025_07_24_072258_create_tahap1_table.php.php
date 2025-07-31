<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahap1Table extends Migration
{
    public function up()
    {
        Schema::create('tahap1', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelaku');
            $table->string('produk');
            $table->string('klasifikasi');
            $table->string('status'); // misal "Masih Dibina" atau "Drop/Tidak Dilanjutkan"
            $table->string('pembina_1')->nullable();
            $table->string('pembina_2')->nullable();
            $table->string('sinergi')->nullable();
            $table->string('nama_kontak_person')->nullable();
            $table->string('no_hp')->nullable();
            $table->tinyInteger('bulan_pertama_pembinaan')->nullable();
            $table->integer('tahun_dibina')->nullable();
            $table->string('riwayat_pembinaan')->nullable();
            $table->string('status_pembinaan')->nullable(); // enum string bisa juga
            $table->string('email')->nullable();
            $table->string('media_sosial')->nullable();
            $table->string('nama_merek')->nullable();
            $table->boolean('jenis_usaha')->default(0); // 1 = pangan, 0 = non pangan
            $table->boolean('sni')->default(0); // 1 = sudah SNI, 0 = belum
            $table->string('lspro')->nullable();
            $table->boolean('tanda_daftar_merk')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tahap1');
    }
}
