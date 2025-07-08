<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        \Log::info('パスワードリセット store() 開始');

        $request->validate(['email' => 'required|email']);
        \Log::info('バリデーション通過');

        $status = Password::sendResetLink(
            $request->only('email')
        );

        \Log::info('Password::sendResetLink の結果', ['status' => $status]);

        return $status === Password::RESET_LINK_SENT
    ? redirect()->route('password.request')->with('status', __('パスワード再設定リンクを送信しました。'))
    : back()->withErrors(['email' => __('メール送信に失敗しました。')]);

    }
}
