@extends('layouts.app')

@section('title', 'ゲスト用トップページ')

@section('content')
<div class="container text-center mt-5">
    <h1>レビューサイトへようこそ！</h1>
    <p>ログインすると、レビューの投稿やブックマーク機能が使えます。</p>
    <a href="{{ route('login') }}" class="btn btn-primary">ログイン</a>
    <a href="{{ route('register') }}" class="btn btn-outline-secondary ms-2">新規登録</a>
</div>
@endsection
