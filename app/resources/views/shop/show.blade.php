@extends('layouts.app')

@section('title', '店舗詳細')

@section('content')
<div class="container">
    <h1 class="mb-3">{{ $shop->name }}</h1>

    {{-- 店舗情報 --}}
    <div class="mb-4">
        <img src="{{ $shop->image }}" class="img-fluid mb-2" alt="{{ $shop->name }}">
        <p><strong>住所：</strong>{{ $shop->address }}</p>
        <p><strong>紹介：</strong>{{ $shop->comment }}</p>
        <p><strong>平均スコア：</strong>{{ number_format($shop->average_score, 1) }} / 5</p>

        {{-- ブックマークボタン --}}
        @auth
            @if ($shop->isBookmarkedBy(Auth::user()))
                <button class="btn btn-secondary" disabled>ブックマーク済み</button>
            @else
                <button id="bookmark-btn" data-shop-id="{{ $shop->id }}" class="btn btn-outline-primary">
                    ブックマーク
                </button>
            @endif
        @endauth
    </div>

    {{-- レビュー投稿ボタン（ゲストはログイン誘導） --}}
    <div class="mb-4">
        @auth
            <a href="{{ route('reviews.create', ['shop_id' => $shop->id]) }}" class="btn btn-primary">レビューを書く</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-secondary">レビューを書く（ログインが必要）</a>
        @endauth
    </div>

    {{-- レビュー一覧 --}}
    <h3 class="mt-5 mb-3">レビュー一覧</h3>

    @forelse ($shop->reviews as $review)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $review->title }}
                    <span class="text-warning">★{{ $review->score }}</span>
                </h5>
                <p class="card-text">{{ $review->content }}</p>

                @if ($review->image)
                    <img src="{{ $review->image }}" class="img-fluid rounded mb-2" alt="レビュー画像">
                @endif

                <p class="card-text">
                    <small class="text-muted">
                        投稿者: {{ $review->user->name }} /
                        投稿日: {{ $review->created_at->format('Y-m-d') }}
                    </small>
                </p>

                <a href="{{ route('reviews.show', $review->id) }}" class="btn btn-sm btn-outline-secondary">詳細を見る</a>

                {{-- 違反報告リンク（ログインユーザーのみ） --}}
                @auth
                    <form method="GET" action="{{ route('violations.create') }}" class="d-inline ms-2">
                        <input type="hidden" name="review_id" value="{{ $review->id }}">
                        <button type="submit" class="btn btn-sm btn-outline-danger">違反報告</button>
                    </form>
                @endauth
            </div>
        </div>
    @empty
        <p>レビューはまだありません。</p>
    @endforelse
</div>

{{-- ブックマークAjax処理 --}}
@auth
    @if (!$shop->isBookmarkedBy(Auth::user()))
        <script>
            document.getElementById('bookmark-btn').addEventListener('click', function () {
                const shopId = this.dataset.shopId;

                fetch('/bookmarks', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ shop_id: shopId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'bookmarked') {
                        alert('ブックマークしました');
                        location.reload();
                    } else {
                        alert('登録失敗');
                    }
                });
            });
        </script>
    @endif
@endauth
@endsection
