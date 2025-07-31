<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('produksi', function (Blueprint $table) {
            // Tambahkan kolom baru bertipe JSON untuk multiple gambar
            if (!Schema::hasColumn('produksi', 'foto_produk')) {
                $table->json('foto_produk')->nullable()->after('jangkauan_pemasaran');
            }

            if (!Schema::hasColumn('produksi', 'foto_tempat_produksi')) {
                $table->json('foto_tempat_produksi')->nullable()->after('foto_produk');
            }
        });
    }

    public function down()
    {
        Schema::table('produksi', function (Blueprint $table) {
            // Hapus kembali kolom jika rollback
            $table->dropColumn(['foto_produk', 'foto_tempat_produksi']);
        });
    }
};
