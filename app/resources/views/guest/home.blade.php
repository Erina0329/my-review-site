@extends('layouts.app')

@section('title', 'ゲストトップ')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">ようこそ！レビューサイトへ</h1>
    <p>会員登録すると、レビュー投稿やブックマークが可能になります。</p>

    <div class="mb-4">
        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">ログイン</a>
        <a href="{{ route('register') }}" class="btn btn-primary">新規登録</a>
    </div>

    <hr>

    <h2 class="mt-5 mb-4">店舗情報を見る</h2>
    <a href="{{ route('shops.index') }}" class="btn btn-success">店舗一覧はこちら</a>
</div>
@endsection
