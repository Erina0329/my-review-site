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

        Bookmark::firstOrCreate([
            'user_id' => Auth::id(),
            'shop_id' => $request->shop_id,
        ]);

        return response()->json(['status' => 'bookmarked']);
    }

    /**
     * ブックマーク削除（Ajax・DELETE）
     */
    public function destroy($shopId)
    {
        Bookmark::where('user_id', Auth::id())
                ->where('shop_id', $shopId)
                ->delete();

        return response()->json(['status' => 'unbookmarked']);
    }
}
