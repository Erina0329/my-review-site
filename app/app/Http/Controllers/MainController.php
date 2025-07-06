<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;

class MainController extends Controller
{
    public function index()
    {
        // 店舗一覧に平均レビュー点を付加して取得
        $shops = Shop::withAvg('reviews', 'score')->get();

        return view('guest.home', compact('shops'));
    }
}
