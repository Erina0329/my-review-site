<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;

class AdminController extends Controller
{
    /**
     * 管理者ダッシュボード
     */
    public function mypage()
    {
        return view('admin.mypage');
    }

    /**
     * ユーザー一覧（違反数含む）
     */
    public function userList()
    {
        // 各ユーザーのレビューに紐づく violations をカウントする
        $users = User::withTrashed()->withCount(['reviews as hidden_reviews_count' => function ($query) {
            $query->onlyTrashed(); // 論理削除された投稿のみ
        }])
        ->orderByDesc('hidden_reviews_count')
        ->take(10)
        ->get();

        return view('admin.user_list', compact('users'));
    }


    /**
     * ユーザー詳細（レビュー投稿と違反数含む）
     */
    public function userDetail($id)
    {
        $user = User::with(['reviews.violations', 'reviews.shop'])->findOrFail($id);

        return view('admin.user_detail', compact('user'));
    }

   
    public function postList()
    {
        $reviews = Review::withTrashed()
            ->with(['user', 'shop', 'violations'])
            ->withCount('violations')
            ->orderByDesc('violations_count')
            ->take(50) // 一旦多めに取得して後で制御できるようにする
            ->get();

        // ここで user が存在するレビューだけに絞る（論理削除されたユーザーも含めるには不要）
        $reviews = $reviews->filter(function ($review) {
            return $review->user !== null; // もしくは任意の条件
        })->take(20); // ここで最終的に20件に絞る

    return view('admin.post_list', compact('reviews'));
    }
    
    public function postDetail($id)
    {
    $review = Review::with(['user', 'shop', 'violations.user'])->findOrFail($id);

    return view('admin.post_detail', compact('review'));
    }

    public function reviewDetail($id)
    {
    $review = Review::with(['user', 'shop', 'violations.user'])
        ->whereHas('violations') // 違反報告があるレビューに限定
        ->findOrFail($id);

    return view('admin.review_detail', compact('review'));
    }


}
