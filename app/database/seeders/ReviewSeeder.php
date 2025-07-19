<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'shop_id' => 1,
                'user_id' => 1,
                'review' => 'お肉がとてもジューシーで、コスパ最高でした！また行きたいです。',
                'score' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shop_id' => 1,
                'user_id' => 2,
                'review' => '少し高めな印象でした。',
                'score' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'shop_id' => 3,
                'user_id' => 2,
                'review' => 'ゆったりとした時間を過ごせて癒されました。',
                'score' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
