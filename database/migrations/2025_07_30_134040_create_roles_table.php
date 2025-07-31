<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Contoh: admin, user
            $table->string('description')->nullable(); // Contoh: 'Admin dapat mengakses semua fitur'
            $table->timestamps();
        });

        // Optional: seeding awal dua role
        DB::table('roles')->insert([
            ['name' => 'admin', 'description' => 'Administrator, akses penuh', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'user', 'description' => 'Pengguna biasa, akses terbatas', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
}
