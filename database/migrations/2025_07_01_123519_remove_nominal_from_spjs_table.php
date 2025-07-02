<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spjs', function (Blueprint $table) {
            // Hapus kolom nominal dari tabel spjs
            $table->dropColumn('nominal');
        });
    }

    public function down(): void
    {
        Schema::table('spjs', function (Blueprint $table) {
            // Tambahkan kembali kolom nominal jika rollback
            $table->decimal('nominal', 15, 2)->nullable(); // atau NOT NULL tergantung sebelumnya
        });
    }
};
