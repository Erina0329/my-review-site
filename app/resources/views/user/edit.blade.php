@extends('layouts.app')

@section('title', 'アカウント編集')

@section('content')
<div class="container">
    <h1 class="mb-4">アカウント編集</h1>

    {{-- バリデーションエラー表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 編集フォーム --}}
    <form action="{{ route('user.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">ユーザー名</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">新しいパスワード（空欄で変更なし）</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">新しいパスワード（確認）</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
        <a href="{{ route('user.mypage') }}" class="btn btn-secondary">戻る</a>
    </form>
</div>
@endsection
