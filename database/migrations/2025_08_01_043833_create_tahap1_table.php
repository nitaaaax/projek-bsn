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

                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('tahap1');
        }
    }
