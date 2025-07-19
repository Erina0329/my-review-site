@extends('layouts.app')

@section('title', '自店舗レビュー一覧')

@section('content')
<div class="container">
    <h2 class="mb-4">「{{ $shop->name }}」のレビュー一覧</h2>

    @forelse ($reviews as $review)
        <div class="card mb-3">
            <div class="card-body">
                <p class="card-text">{{ $review->review }}</p>
                <p><strong>評価：</strong> <span class="text-warning">★{{ $review->score }}</span></p>
                <p><strong>投稿者：</strong> {{ $review->user->name }} / {{ $review->created_at->format('Y-m-d') }}</p>
                @if ($review->image_path)
                    <img src="{{ asset('storage/' . $review->image_path) }}" alt="レビュー画像" style="max-height: 150px;">
                @endif
            </div>
        </div>
    @empty
        <p>まだレビューがありません。</p>
    @endforelse
</div>
@endsection
