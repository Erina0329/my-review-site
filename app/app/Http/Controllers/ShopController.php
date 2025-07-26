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
        $minScore = $request->input('min_score') ? floor($request->input('min_score')) : null;
        $maxScore = $request->input('max_score') ? floor($request->input('max_score')) : null;

        // 店舗情報と平均レビュー点を計算
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

        // 平均レビュー点数で絞り込み（整数化して比較）
        if ($minScore && $maxScore) {
            $query->havingRaw('FLOOR(AVG(reviews.score)) BETWEEN ? AND ?', [$minScore, $maxScore]);
        } elseif ($minScore) {
            $query->havingRaw('FLOOR(AVG(reviews.score)) >= ?', [$minScore]);
        } elseif ($maxScore) {
            $query->havingRaw('FLOOR(AVG(reviews.score)) <= ?', [$maxScore]);
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
