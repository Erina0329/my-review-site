<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * 新規登録フォーム表示（GET /register）
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * 新規登録処理（POST /register）
     */
    public function store(Request $request)
    {
        // バリデーションルール
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // ユーザー作成
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // イベント発火（メール通知等）
        event(new Registered($user));

        // 自動ログインはせず、ログイン画面へリダイレクト
        return redirect()->route('login')->with('status', '登録が完了しました。ログインしてください。');
    }
}
