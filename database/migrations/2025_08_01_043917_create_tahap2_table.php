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
                $table->unsignedBigInteger('pelaku_usaha_id'); // Foreign key ke tahap1.id

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

                // Foreign Key ke tahap1
                $table->foreign('pelaku_usaha_id')
                    ->references('id')->on('tahap1')
                    ->onDelete('cascade');
            });
        }

        public function down()
        {
            Schema::dropIfExists('tahap2');
        }
    }
