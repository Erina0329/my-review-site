<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('shops')->insert([
            [
                'name' => '焼肉 太郎 赤坂店',
                'user_id' => 4,
                'image_path' => 'images/yakiniku_taro.jpg',
                'address' => '東京都港区赤坂3-4-5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '寿司 花丸 渋谷店',
                'user_id' => 4,
                'image_path' => 'images/sushi_hanamaru.jpg',
                'address' => '東京都渋谷区宇田川町12-1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'カフェ ねこじゃらし',
                'user_id' => 4,
                'image_path' => 'images/cafe_neko.jpg',
                'address' => '東京都世田谷区下北沢2-10-3',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
