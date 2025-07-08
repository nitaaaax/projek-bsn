<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pelaku_usaha', function (Blueprint $table) {
            $table->string('pembina_1', 100)->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('pelaku_usaha', function (Blueprint $table) {
            $table->dropColumn('pembina_1');
        });
    }
};