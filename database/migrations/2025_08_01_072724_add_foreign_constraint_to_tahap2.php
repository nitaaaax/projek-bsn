<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tahap2', function (Blueprint $table) {
            $table->foreign('pelaku_usaha_id')
                  ->references('id')
                  ->on('pelaku_usaha')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tahap2', function (Blueprint $table) {
            $table->dropForeign(['pelaku_usaha_id']);
        });
    }
};
