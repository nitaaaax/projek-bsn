<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'username' => 'Admin456',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role_id' => 1,
        ]);

        // Regular user
        User::create([
            'username' => 'User456',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'role_id' => 2,
        ]);
    }
}
