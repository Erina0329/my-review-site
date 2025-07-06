@extends('layouts.app')

@section('title', 'パスワード再設定')

@section('content')
<div class="container">
    <h1 class="mb-4">パスワードをお忘れですか？</h1>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">メールアドレス</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">再設定リンクを送信</button>
    </form>
</div>
@endsection
