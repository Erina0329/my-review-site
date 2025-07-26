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
        $reviewId = $request->query('review_id'); // URLパラメータからレビューID取得
        $review = Review::with('user', 'shop')->findOrFail($reviewId);

        return view('report.create', compact('review'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'review_id' => 'required|exists:reviews,id',
            'reason' => 'required|string|max:255',
        ]);

        Violation::create([
            'user_id' => auth()->id(),
            'review_id' => $request->review_id,
            'reason' => $request->reason,
        ]);

        // リダイレクト先が送信されていたらそこへ戻す
        if ($request->filled('redirect_to')) {
            return redirect($request->input('redirect_to'))
                ->with('success', '違反報告を送信しました。');
        }

        // デフォルトの遷移先（なければレビュー詳細へ）
        return redirect()->route('reviews.show', $request->review_id)
                        ->with('success', '違反報告を送信しました。');
    }
}
