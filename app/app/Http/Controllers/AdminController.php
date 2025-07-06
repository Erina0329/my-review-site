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
        $users = User::withCount([
            'reviews as violation_reports_count' => function ($query) {
                $query->join('violations', 'reviews.id', '=', 'violations.review_id');
            }
        ])->get();

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
    $reviews = Review::with(['user', 'shop', 'violations'])->get();
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
