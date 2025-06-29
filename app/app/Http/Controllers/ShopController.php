<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    // 店舗一覧
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $score = $request->input('score');

        $query = Shop::with('reviews');

        // キーワード検索（店舗名・住所・レビュー内容）
        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%")
                  ->orWhereHas('reviews', function ($q) use ($keyword) {
                      $q->where('title', 'like', "%{$keyword}%")
                        ->orWhere('content', 'like', "%{$keyword}%");
                  });
        }

        // レビュー点数で絞り込み
        if ($score) {
            $query->whereHas('reviews', function ($q) use ($score) {
                $q->where('score', $score);
            });
        }

        $shops = $query->get();

        return view('shop.index', compact('shops'));
    }

    // 店舗詳細
    public function show($id)
    {
        $shop = Shop::with(['reviews.user'])->findOrFail($id);
        return view('shop.show', compact('shop'));
    }
}
