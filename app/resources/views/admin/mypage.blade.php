@extends('layouts.app')

@section('title', '管理者マイページ')

@section('content')
<div class="container">
    <h1 class="mb-4">管理者ダッシュボード</h1>

    <ul class="list-group">
        <li class="list-group-item">
            <a href="{{ route('admin.user_list') }}">ユーザー一覧を見る</a>
        </li>
        <li class="list-group-item">
            <a href="{{ route('admin.post_list') }}">レビュー一覧を見る</a>
        </li>
    </ul>
</div>
@endsection
