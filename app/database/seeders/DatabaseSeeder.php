<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

User::create([
    'name' => 'admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password'),
    'role' => 0,
]);

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(ShopSeeder::class);
        $this->call(ReviewSeeder::class);
    }
}
