<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        // Tabel roles
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Wajib diisi
            $table->string('description')->nullable(); // Bisa kosong
            $table->timestamps();
        });

        // Isi role langsung
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'description' => 'Administrator, akses penuh',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'user',
                'description' => 'Pengguna biasa, akses terbatas',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // Tabel users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');

            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
    }
};
