<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ログインユーザーのマイページ
    public function mypage()
    {
        return view('user.mypage');
    }

    // アカウント編集画面を表示
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    // アカウント情報を更新
    public function update(Request $request)
    {
        $user = Auth::user();

        // バリデーション
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:100|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // 値の更新
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('mypage')->with('success', 'アカウント情報を更新しました。');
    }
}
