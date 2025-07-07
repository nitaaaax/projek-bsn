<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('spjs', function (Blueprint $table) {
            $table->string('no_ukd')->nullable()->after('nama_spj');
        });
    }

    public function down(): void
    {
        Schema::table('spjs', function (Blueprint $table) {
            $table->dropColumn('no_ukd');
        });
    }

};
