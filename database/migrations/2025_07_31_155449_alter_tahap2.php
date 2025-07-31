<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tahap2', function (Blueprint $table) {
            // Buat kolom jika belum ada
            if (!Schema::hasColumn('tahap2', 'pelaku_usaha_id')) {
                $table->unsignedBigInteger('pelaku_usaha_id')->nullable()->after('id');
            } else {
                $table->unsignedBigInteger('pelaku_usaha_id')->nullable()->change();
            }

            if (!Schema::hasColumn('tahap2', 'jenis_usaha')) {
                $table->string('jenis_usaha')->nullable()->after('tahun_pendirian');
            }

            if (!Schema::hasColumn('tahap2', 'sni_yang_diterapkan')) {
                $table->text('sni_yang_diterapkan')->nullable()->after('sni_yang_akan_diterapkan');
            }

            if (!Schema::hasColumn('tahap2', 'jangkauan_pemasaran')) {
                $table->json('jangkauan_pemasaran')->nullable()->after('sni_yang_diterapkan');
            }

            if (!Schema::hasColumn('tahap2', 'instansi')) {
                $table->json('instansi')->nullable()->after('jangkauan_pemasaran');
            }

            if (!Schema::hasColumn('tahap2', 'foto_produk')) {
                $table->json('foto_produk')->nullable()->after('instansi');
            }

            if (!Schema::hasColumn('tahap2', 'foto_tempat_produksi')) {
                $table->json('foto_tempat_produksi')->nullable()->after('foto_produk');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tahap2', function (Blueprint $table) {
            $table->dropColumn([
                'pelaku_usaha_id',
                'jenis_usaha',
                'sni_yang_diterapkan',
                'jangkauan_pemasaran',
                'instansi',
                'foto_produk',
                'foto_tempat_produksi',
            ]);
        });
    }
};

