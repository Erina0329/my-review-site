@extends('layouts.app')

@section('title', 'レビュー詳細（管理）')

@section('content')
<div class="container">
    <h1 class="mb-4">レビュー詳細</h1>

    <div class="mb-4">
        <h5>{{ $review->title }}</h5>
        <p><strong>スコア：</strong>★{{ $review->score }}</p>
        <p><strong>本文：</strong>{{ $review->content }}</p>

        @if ($review->image)
            <img src="{{ $review->image }}" class="img-fluid rounded mb-3" alt="レビュー画像">
        @endif

        <p><strong>投稿者：</strong>{{ $review->user->name }}</p>
        <p><strong>店舗名：</strong>{{ $review->shop->name }}</p>
        <p><strong>投稿日：</strong>{{ $review->created_at->format('Y-m-d') }}</p>
    </div>

    <div class="mb-4">
        <h5>違反報告一覧</h5>
        @if ($review->violations->isEmpty())
            <p>違反報告はありません。</p>
        @else
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>報告者</th>
                        <th>理由</th>
                        <th>報告日時</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($review->violations as $violation)
                        <tr>
                            <td>{{ $violation->user->name }}</td>
                            <td>{{ $violation->reason }}</td>
                            <td>{{ $violation->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <a href="{{ route('admin.post_list') }}" class="btn btn-secondary">← 一覧へ戻る</a>
</div>
@endsection
