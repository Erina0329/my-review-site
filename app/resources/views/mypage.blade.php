@extends('layouts.app')

@section('content')
<div class="container">
    <h1>
        @if(auth()->user()->role === 0)
            管理者マイページ
        @elseif(auth()->user()->role === 2)
            店舗管理者マイページ
        @else
            一般ユーザーマイページ
        @endif
    </h1>

    {{-- 共通：ユーザー情報 --}}
    <div class="mb-4">
        <h4>ようこそ、{{ Auth::user()->name }} さん</h4>
        <p><strong>メールアドレス：</strong>{{ Auth::user()->email }}</p>

        @if(auth()->user()->role !== 0) {{-- 管理者は編集・退会不可 --}}
            <a href="{{ route('user.edit') }}" class="btn btn-outline-secondary btn-sm">アカウント編集</a>
            <form method="POST" action="{{ route('profile.destroy') }}" class="d-inline ms-2" onsubmit="return confirm('本当に退会しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger btn-sm">退会</button>
            </form>
        @endif
    </div>

    {{-- ロール別表示 --}}
    @if(auth()->user()->role === 0)
        {{-- 管理者用 --}}
        <div class="list-group mb-5">
            <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action">ユーザー一覧（通報件数順）</a>
            <a href="{{ route('admin.posts.index') }}" class="list-group-item list-group-item-action">投稿一覧（違反件数順）</a>
        </div>

    @elseif(auth()->user()->role === 2)
        {{-- 店舗管理者用 --}}
        <div class="list-group mb-5">
            <a href="{{ route('shop_admin.reviews') }}" class="list-group-item list-group-item-action">自店舗レビュー一覧</a>
            <a href="{{ route('shop_admin.edit') }}" class="list-group-item list-group-item-action">店舗情報編集</a>
        </div>

    @else
        {{-- 一般ユーザー用 --}}

        @php
            $firstShop = \App\Models\Shop::first();
        @endphp

        @if($firstShop)
            <a href="{{ route('reviews.create', ['shop_id' => $firstShop->id]) }}" class="btn btn-primary mb-3">
                新規レビュー投稿
            </a>
        @else
            <p>投稿できる店舗がありません。</p>
        @endif

        <div class="list-group mb-4">
            <a href="{{ route('reviews.index') }}" class="list-group-item list-group-item-action">投稿したレビュー一覧</a>
            <a href="{{ route('bookmarks.index') }}" class="list-group-item list-group-item-action">ブックマーク一覧</a>
        </div>

        <a href="{{ route('shops.index') }}" class="btn btn-primary">店舗一覧へ</a>
    @endif
</div>
@endsection
