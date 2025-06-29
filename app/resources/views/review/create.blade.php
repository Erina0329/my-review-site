@extends('layouts.app')

@section('title', 'レビュー投稿')

@section('content')
<div class="container">
    <h1 class="mb-4">レビュー投稿</h1>

    {{-- バリデーションエラー表示 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 投稿フォーム --}}
    <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="shop_id" value="{{ $shop->id }}">

        <div class="mb-3">
            <label for="title" class="form-label">タイトル</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="score" class="form-label">評価（1〜5）</label>
            <select name="score" class="form-select" required>
                <option value="">選択してください</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" @selected(old('score') == $i)>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">内容</label>
            <textarea name="content" rows="5" class="form-control" required>{{ old('content') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">画像（任意）</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">投稿する</button>
        <a href="{{ route('shops.show', $shop->id) }}" class="btn btn-secondary">キャンセル</a>
    </form>
</div>
@endsection
