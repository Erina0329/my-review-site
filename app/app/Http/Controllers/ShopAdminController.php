<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopAdminController extends Controller
{
    // 自店舗レビュー一覧表示
    public function reviews()
    {
        $shop = Shop::where('user_id', Auth::id())->firstOrFail();
        $reviews = Review::with('user')->where('shop_id', $shop->id)->latest()->get();

        return view('shop_admin.reviews', compact('shop', 'reviews'));
    }

    // 店舗情報編集画面表示
    public function edit()
    {
        $shops = \App\Models\Shop::where('user_id', auth()->id())->get();
        return view('shop_admin.edit', compact('shops'));
    }

    public function update(Request $request, $id)
    {
        $shop = \App\Models\Shop::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $shop->image_path = $request->file('image')->store('shop_images', 'public');
        }

        $shop->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
        ]);

        return redirect()->route('shop_admin.edit')->with('success', '店舗情報を更新しました');
    }
}
