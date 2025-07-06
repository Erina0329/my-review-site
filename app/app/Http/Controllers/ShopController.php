<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * 店舗一覧表示
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $score = $request->input('score');

        // 店舗とそのレビューを一緒に取得
        $query = Shop::with('reviews');

        // キーワード検索（店舗名・住所・レビュー内容）
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('address', 'like', "%{$keyword}%")
                  ->orWhereHas('reviews', function ($sub) use ($keyword) {
                      $sub->where('review', 'like', "%{$keyword}%");
                  });
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

    /**
     * 店舗詳細表示
     */
    public function show($id)
    {
        $shop = Shop::with(['reviews.user'])->findOrFail($id);
        return view('shop.show', compact('shop'));
    }
}
