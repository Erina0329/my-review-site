@extends('layouts.app')

@section('title', '店舗詳細')

@section('content')
<div class="container">
    <h1 class="mb-3">{{ $shop->name }}</h1>

    {{-- 店舗情報 --}}
    <div class="mb-4">
        <img src="{{ asset($shop->image_path ?? 'images/no_image.jpg') }}" class="img-fluid mb-2" alt="{{ $shop->name }}">

        <p><strong>住所：</strong>{{ $shop->address }}</p>
        <p><strong>紹介：</strong>{{ $shop->comment }}</p>
        <p><strong>平均スコア：</strong>{{ number_format($shop->average_score, 1) }} / 5</p>

        {{-- ブックマークボタン --}}
        @auth
            @if ($shop->isBookmarkedBy(Auth::user()))
                <button id="bookmark-btn"
                        data-bookmarked="true"
                        data-shop-id="{{ $shop->id }}"
                        class="btn btn-secondary">
                    ブックマーク済み
                </button>
            @else
                <button id="bookmark-btn"
                        data-bookmarked="false"
                        data-shop-id="{{ $shop->id }}"
                        class="btn btn-outline-primary">
                    ブックマーク
                </button>
            @endif
        @endauth

    </div>

    {{-- レビュー投稿ボタン（ゲストはログイン誘導） --}}
    <div class="mb-4">
        @if(Auth::user() && Auth::user()->role === 1)
        @auth
            <a href="{{ route('reviews.create', ['shop_id' => $shop->id]) }}" class="btn btn-primary">レビューを書く</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-outline-secondary">レビューを書く（ログインが必要）</a>
        @endauth
        @endif
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('bookmark-btn');
    if (!btn) return;

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    btn.addEventListener('click', function () {
        const shopId = btn.getAttribute('data-shop-id');
        const isBookmarked = btn.getAttribute('data-bookmarked') === 'true';

        const method = isBookmarked ? 'DELETE' : 'POST';
        const url = '/bookmarks' + (isBookmarked ? `/${shopId}` : '');

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: isBookmarked ? null : JSON.stringify({ shop_id: shopId })
        })
        .then(res => {
            if (!res.ok) throw new Error('Network error');
            return res.json();
        })
        .then(data => {
            if (isBookmarked) {
                btn.textContent = 'ブックマーク';
                btn.classList.remove('btn-secondary');
                btn.classList.add('btn-outline-primary');
                btn.setAttribute('data-bookmarked', 'false');
            } else {
                btn.textContent = 'ブックマーク済み';
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-secondary');
                btn.setAttribute('data-bookmarked', 'true');
            }
        })
        .catch(err => {
            console.error('Error:', err);
        });
    });
});
</script>
@endsection
