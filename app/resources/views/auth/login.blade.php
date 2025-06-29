@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
<div class="container" style="max-width: 480px; margin-top: 80px;">
    <h2 class="mb-4 text-center">ログイン</h2>

    {{-- メール送信や失敗のメッセージ --}}
    @if (session('status'))
        <div class="alert alert-success small text-center">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger small text-center">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- メールアドレス --}}
        <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- パスワード --}}
        <div class="mb-3">
            <label for="password" class="form-label">パスワード</label>
            <input type="password" name="password" id="password"
                class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- ログイン状態保持 --}}
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                ログイン状態を保持
            </label>
        </div>

        {{-- ログインボタン --}}
        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary">ログイン</button>
        </div>

        {{-- パスワード再設定リンク --}}
        <div class="text-center mb-2">
            <a href="{{ route('password.request') }}" class="text-decoration-none">パスワードをお忘れですか？</a>
        </div>

        {{-- 新規登録へのリンク --}}
        <div class="text-center">
            <a href="{{ route('register') }}" class="text-decoration-none">新規登録はこちら</a>
        </div>
    </form>
</div>
@endsection
