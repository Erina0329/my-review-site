<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Shop;

class ReviewController extends Controller
{
    // 自分のレビュー一覧or 管理者向けレビュー一覧
    public function index()
    {
        $reviews = Review::with('shop', 'user')->latest()->get();
        return view('review.index', compact('reviews'));
    }

    // 自分の投稿だけ
    public function myReviews()
    {
        $reviews = Review::with('shop')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.reviews', compact('reviews'));
    }


    // 新規投稿フォーム
    public function create(Request $request)
    {
        $shop = Shop::findOrFail($request->input('shop_id'));
        return view('review.create', compact('shop'));
    }

    // 投稿保存
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'title'   => 'required|max:100',
            'score'   => 'required|integer|between:1,5',
            'content' => 'required',
            'image'   => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reviews', 'public');
        }

        Review::create([
            'user_id' => Auth::id(),
            'shop_id' => $validated['shop_id'],
            'title'   => $validated['title'],
            'score'   => $validated['score'],
            'content' => $validated['content'],
            'image'   => $path,
        ]);

        return redirect()->route('reviews.index')->with('success', 'レビューを投稿しました。');
    }

    // レビュー詳細
    public function show($id)
    {
        $review = Review::with('user', 'shop')->findOrFail($id);
        return view('review.show', compact('review'));
    }

    // 投稿削除
    public function destroy($id)
    {
        $review = Review::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $review->delete();

        return redirect()->route('reviews.index')->with('success', 'レビューを削除しました。');
    }

    // 編集フォーム
    public function edit($id)
    {
        $review = Review::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('review.edit', compact('review'));
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $review = Review::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'title'   => 'required|max:100',
            'score'   => 'required|integer|between:1,5',
            'content' => 'required',
            'image'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('reviews', 'public');
            $review->image = $path;
        }

        $review->fill($validated)->save();

        return redirect()->route('reviews.index')->with('success', 'レビューを更新しました。');
    }

}
