<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('alamat', function (Blueprint $table) {
        $table->string('alamat_kantor')->nullable()->after('tahun_pendirian');
        $table->string('provinsi_kantor')->nullable()->after('alamat_kantor');
        $table->string('kota_kantor')->nullable()->after('provinsi_kantor');

        $table->string('alamat_pabrik')->nullable()->after('kota_kantor');
        $table->string('provinsi_pabrik')->nullable()->after('alamat_pabrik');
        $table->string('kota_pabrik')->nullable()->after('provinsi_pabrik');
    });
}

public function down(): void
{
    Schema::table('alamat', function (Blueprint $table) {
        $table->dropColumn([
            'alamat_kantor',
            'provinsi_kantor',
            'kota_kantor',
            'alamat_pabrik',
            'provinsi_pabrik',
            'kota_pabrik',
        ]);
    });
}

};
