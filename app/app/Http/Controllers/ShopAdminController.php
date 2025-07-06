<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopAdminController extends Controller
{
    // 自店舗レビュー一覧表示
    public function reviews()
    {
        return view('shop_admin.reviews'); // Bladeファイル：resources/views/shop_admin/reviews.blade.php
    }

    // 店舗情報編集画面表示
    public function edit()
    {
        return view('shop_admin.edit'); // Bladeファイル：resources/views/shop_admin/edit.blade.php
    }
}
