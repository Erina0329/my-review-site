<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * ゲストのみアクセス許可
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * ログインフォーム表示（GET /login）
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('user.mypage');
        }

        return view('auth.login');
    }

    /**
     * ログイン処理（POST /login）
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'メールアドレスは必須項目です。',
            'email.email' => 'メールアドレスの形式が正しくありません。',
            'password.required' => 'パスワードは必須項目です。',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended($this->redirectTo());
        }

        // エラーを両フィールドにセット
        throw ValidationException::withMessages([
            'email' => ['認証に失敗しました。'],
            'password' => ['認証に失敗しました。'],
        ]);
    }

    /**
     * ログアウト処理
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('guest.home');
    }

    /**
     * ログイン後のリダイレクト先
     */
    protected function redirectTo()
    {
        return route('user.mypage');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.mypage');
        } elseif ($user->role === 'shop') {
            return redirect()->route('shop_admin.mypage');
        } else {
            return redirect()->route('user.mypage');
        }
    }

}
