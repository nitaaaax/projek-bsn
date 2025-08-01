<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('tahap1');

        Schema::create('tahap1', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelaku');
            $table->string('produk');
            $table->string('klasifikasi');
            $table->string('status');
            $table->string('pembina_1')->nullable();
            $table->string('pembina_2')->nullable();
            $table->string('sinergi')->nullable();
            $table->string('nama_kontak_person')->nullable();
            $table->string('no_hp')->nullable();
            $table->tinyInteger('bulan_pertama_pembinaan')->nullable();
            $table->integer('tahun_dibina')->nullable();
            $table->string('riwayat_pembinaan')->nullable();
            $table->string('status_pembinaan')->nullable();
            $table->string('email')->nullable();
            $table->string('media_sosial')->nullable();
            $table->string('nama_merek')->nullable();
            $table->string('jenis_usaha')->nullable();
            $table->tinyInteger('sni')->default(0);
            $table->string('lspro')->nullable();
            $table->tinyInteger('tanda_daftar_merk')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahap1');
    }
};