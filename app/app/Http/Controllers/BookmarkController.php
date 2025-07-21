<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * ブックマーク一覧表示
     */
    public function index()
    {
        $bookmarks = Bookmark::with('shop')->where('user_id', Auth::id())->get();
        return view('bookmark.index', compact('bookmarks'));
    }



    /**
     * ブックマーク登録（Ajax・POST）
     */
    public function store(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
        ]);

        $user = Auth::user();

        // すでに登録済みか確認
        $exists = $user->bookmarks()->where('shop_id', $request->shop_id)->exists();

        if (! $exists) {
            $user->bookmarks()->create([
                'shop_id' => $request->shop_id,
            ]);
        }

        return response()->json(['status' => 'bookmarked']);
    }

    /**
     * ブックマーク削除（Ajax・DELETE）
     */
    public function destroy(Shop $shop)
    {
        $user = Auth::user();

        $user->bookmarks()
            ->where('shop_id', $shop->id)
            ->delete();

        return response()->json(['status' => 'unbookmarked']);
    }
}
