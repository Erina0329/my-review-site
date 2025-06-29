<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Violation;
use App\Models\Review;

class ViolationController extends Controller
{
    // 違反報告フォーム
    public function create(Request $request)
    {
        $review = Review::findOrFail($request->input('review_id'));
        return view('report.create', compact('review'));
    }

    // 違反報告登録処理
    public function store(Request $request)
    {
        $request->validate([
            'review_id' => 'required|exists:reviews,id',
            'reason' => 'required|string|max:255',
        ]);

        Violation::create([
            'user_id' => Auth::id(),
            'review_id' => $request->review_id,
            'reason' => $request->reason,
        ]);

        return redirect()->route('reviews.index')->with('success', '違反報告を送信しました。');
    }
}
