@extends('layouts.app')

@section('title', 'ユーザー詳細')

@section('content')
<div class="container">
    <h1 class="mb-4">ユーザー詳細</h1>

    <div class="mb-4">
        <h5>基本情報</h5>
        <p><strong>名前：</strong>{{ $user->name }}</p>
        <p><strong>メール：</strong>{{ $user->email }}</p>
        <p><strong>登録日：</strong>{{ $user->created_at->format('Y-m-d') }}</p>
    </div>

    <div class="mb-4">
        <h5>投稿レビュー一覧</h5>
        @if ($user->reviews->isEmpty())
            <p>レビュー投稿はありません。</p>
        @else
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>店舗名</th>
                        <th>タイトル</th>
                        <th>スコア</th>
                        <th>違反報告数</th>
                        <th>投稿日</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->reviews as $review)
                        <tr @if ($review->violations->count() > 0) class="table-danger" @endif>
                            <td>{{ $review->shop->name ?? '-' }}</td>
                            <td>{{ $review->title }}</td>
                            <td>{{ $review->score }}</td>
                            <td>{{ $review->violations->count() }}</td>
                            <td>{{ $review->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <a href="{{ route('admin.user_list') }}" class="btn btn-secondary">← 一覧へ戻る</a>
</div>
@endsection
