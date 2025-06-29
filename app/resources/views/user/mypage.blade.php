@extends('layouts.app')

@section('title', 'マイページ')

@section('content')
<div class="container">
    <h1 class="mb-4">マイページ</h1>

    {{-- ユーザー情報 --}}
    <div class="mb-4">
        <h4>ようこそ、{{ Auth::user()->name }} さん</h4>
        <p><strong>メールアドレス：</strong>{{ Auth::user()->email }}</p>
        <a href="{{ route('user.edit') }}" class="btn btn-outline-secondary btn-sm">アカウント編集</a>
        <form method="POST" action="{{ route('logout') }}" class="d-inline ms-2">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">ログアウト</button>
        </form>
    </div>

    {{-- メニューリンク --}}
    <div class="list-group mb-5">
        <a href="{{ route('reviews.index') }}" class="list-group-item list-group-item-action">投稿したレビュー一覧</a>
        <a href="{{ route('bookmarks.index') }}" class="list-group-item list-group-item-action">ブックマーク一覧</a>
    </div>

    {{-- 投稿ボタン --}}
    <a href="{{ route('shops.index') }}" class="btn btn-primary">店舗一覧へ</a>
</div>
@endsection
