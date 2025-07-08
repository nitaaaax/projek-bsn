<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kontak', function (Blueprint $table) {
            $table->string('pembina_2')->nullable()->after('pelaku_usaha_id');
            $table->string('sinergi')->nullable()->after('pembina_2');
        });
    }

    public function down(): void
    {
        Schema::table('kontak', function (Blueprint $table) {
            $table->dropColumn(['pembina_2', 'sinergi']);
        });
    }
};
