@extends('layouts.app')

@section('title', 'レビュー詳細')

@section('content')
<div class="container">
    <h1 class="mb-4">レビュー詳細</h1>

    <div class="card mb-3">
        @if ($review->image_path)
            <img src="{{ asset('storage/' . $review->image_path) }}" class="card-img-top" alt="レビュー画像">
        @endif

        <div class="card-body">
            <h5 class="card-title text-primary">
                {{ $review->shop->name }}
            </h5>

            <p class="card-text"><strong>評価：</strong>
                <span class="text-warning">★{{ $review->score }}</span>
            </p>

            <p class="card-text"><strong>投稿者：</strong>{{ $review->user->name }}</p>
            <p class="card-text"><strong>レビュー内容：</strong></p>
            <p class="card-text">{{ $review->review }}</p>

            <p class="card-text"><small class="text-muted">投稿日：{{ $review->created_at->format('Y年m月d日 H:i') }}</small></p>

            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">戻る</a>
        </div>
    </div>
</div>
@endsection
