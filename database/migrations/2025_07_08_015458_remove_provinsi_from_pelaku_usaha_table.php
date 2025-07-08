<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pelaku_usaha', function (Blueprint $table) {
            if (Schema::hasColumn('pelaku_usaha', 'provinsi')) {
                $table->dropColumn('provinsi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pelaku_usaha', function (Blueprint $table) {
            $table->string('provinsi', 100)->nullable();
        });
    }
};
