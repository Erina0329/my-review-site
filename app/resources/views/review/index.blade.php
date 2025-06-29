@extends('layouts.app')

@section('title', '投稿一覧')

@section('content')
<div class="container">
    <h1 class="mb-4">あなたのレビュー一覧</h1>

    @if ($reviews->isEmpty())
        <p>まだレビューが投稿されていません。</p>
    @else
        @foreach ($reviews as $review)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        {{ $review->title }} <span class="text-warning">★{{ $review->score }}</span>
                    </h5>
                    <p class="card-text">{{ Str::limit($review->content, 100) }}</p>
                    <p class="card-text"><small class="text-muted">店舗：{{ $review->shop->name }} / 投稿日：{{ $review->created_at->format('Y-m-d') }}</small></p>

                    <a href="{{ route('reviews.show', $review->id) }}" class="btn btn-outline-secondary btn-sm">詳細</a>
                    <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-outline-primary btn-sm">編集</a>
                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('削除してもよろしいですか？');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm">削除</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
