<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTahap2Table extends Migration
{
    public function up()
    {
        Schema::create('tahap2', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelaku_usaha_id'); // FK ke tahap1.id
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
            $table->string('jangkauan_pemasaran')->nullable();
            $table->string('link_dokumen')->nullable();
            $table->json('foto_produk')->nullable(); // simpan array foto sebagai JSON
            $table->json('foto_tempat_produksi')->nullable();
            $table->timestamps();

            $table->foreign('pelaku_usaha_id')->references('id')->on('tahap1')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tahap2');
    }
}
