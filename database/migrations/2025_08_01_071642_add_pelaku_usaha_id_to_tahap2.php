<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tahap2', function (Blueprint $table) {
            $table->unsignedBigInteger('pelaku_usaha_id')
                  ->nullable()
                  ->after('id'); // kolom ditambahkan setelah 'id'

            $table->foreign('pelaku_usaha_id')
                  ->references('id')
                  ->on('pelaku_usaha')
                  ->onDelete('set null'); // bisa diganti 'cascade' jika ingin data dihapus bersama induknya
        });
    }

    public function down(): void
    {
        Schema::table('tahap2', function (Blueprint $table) {
            $table->dropForeign(['pelaku_usaha_id']);
            $table->dropColumn('pelaku_usaha_id');
        });
    }
};

