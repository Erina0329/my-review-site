<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    /**
     * 店舗一覧表示
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $minScore = $request->filled('min_score') ? (float)$request->input('min_score') : null;
        $maxScore = $request->filled('max_score') ? (float)$request->input('max_score') : null;

        // ★ 検索する前は全店舗（レビューがなくても表示）
        $query = Shop::select('shops.*', DB::raw('AVG(reviews.score) as avg_score'))
            ->leftJoin('reviews', 'shops.id', '=', 'reviews.shop_id')
            ->groupBy('shops.id');

        // キーワード検索
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('shops.name', 'like', "%{$keyword}%")
                ->orWhere('shops.address', 'like', "%{$keyword}%")
                ->orWhere('reviews.content', 'like', "%{$keyword}%");
            });
        }

        // ★ min_score または max_score が指定された場合のみ HAVING を適用
        if (!is_null($minScore) || !is_null($maxScore)) {
            $query->havingRaw('COUNT(reviews.id) > 0'); // レビューがある店舗だけ

            if (!is_null($minScore) && !is_null($maxScore)) {
                $query->havingRaw('AVG(reviews.score) BETWEEN ? AND ?', [$minScore, $maxScore]);
            } elseif (!is_null($minScore)) {
                $query->havingRaw('AVG(reviews.score) >= ?', [$minScore]);
            } elseif (!is_null($maxScore)) {
                $query->havingRaw('AVG(reviews.score) <= ?', [$maxScore]);
            }
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

    public function create()
    {
        abort_unless(in_array(auth()->user()->role, [0, 2]), 403);
        return view('shop.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array(auth()->user()->role, [0, 2]), 403);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'address' => 'required|string|max:255',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('images', 'public')
            : 'images/noimage.jpg';

        Shop::create([
            'user_id'    => auth()->id(),
            'name' => $validated['name'],
            'image_path' => $imagePath,
            'address' => $validated['address'],
        ]);

        return redirect()->route('mypage')->with('success', '店舗を登録しました');
    }
}
