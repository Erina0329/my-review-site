@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="w-100" style="max-width: 480px;">
        <h2 class="mb-4 text-center fw-bold">新規登録</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- ユーザー名 --}}
            <div class="mb-3">
                <label for="name" class="form-label">ユーザー名</label>
                <input type="text" name="name" id="name"
                       class="form-control"
                       value="{{ old('name') }}">
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- メールアドレス --}}
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" name="email" id="email"
                       class="form-control"
                       value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- パスワード --}}
            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" name="password" id="password"
                       class="form-control">
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- パスワード確認 --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">パスワード確認</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="form-control">
                {{-- 通常この項目のエラーは password に統合されているため、個別エラー不要 --}}
            </div>

            {{-- ロール選択 --}}
            <div class="mb-3">
                <label for="role" class="form-label">登録種別</label>
                <select name="role" required>
                    <option value="1">一般ユーザー</option>
                    <option value="2">店舗ユーザー</option>
                    <option value="0">管理者</option>
                </select>

            </div>
 
            {{-- 登録ボタン・キャンセルボタン --}}
            <div class="d-flex justify-content-between mt-4">
                <button type="submit" class="btn btn-primary w-50 me-2">登録</button>
                <a href="{{ route('login') }}" class="btn btn-primary w-50">キャンセル</a>
            </div>
        </form>
    </div>
</div>
@endsection
