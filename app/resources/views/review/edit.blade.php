@extends('layouts.app')

@section('title', 'レビュー編集')

@section('content')
<div class="container">
    <h1 class="mb-4">レビューを編集</h1>

    <form action="{{ route('reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">店舗名</label>
            <input type="text" class="form-control" value="{{ $review->shop->name }}" disabled>
        </div>

        <div class="mb-3">
            <label class="form-label">評価（1〜5）</label>
            <select name="score" class="form-control" required>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ $review->score == $i ? 'selected' : '' }}>★{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">レビュー内容</label>
            <textarea name="review" class="form-control" rows="5" required>{{ old('review', $review->review) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">画像（任意）</label>
            @if ($review->image_path)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $review->image_path) }}" alt="レビュー画像" style="max-height: 200px;">
                </div>
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">更新する</button>
        <a href="{{ route('reviews.index') }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
@endsection
