<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => '一般ユーザー',
                'email' => 'ernk0329@gmail.com',
                'password' => Hash::make('echan5953'),
                'role' => 1, // 一般
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '管理ユーザー',
                'email' => 'kanrisya@gmail.com',
                'password' => Hash::make('echan5953'),
                'role' => 0, // 管理者
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '店舗管理ユーザー',
                'email' => 'tenpokanrisya@gmail.com',
                'password' => Hash::make('echan5953'),
                'role' => 2, // 店舗
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
