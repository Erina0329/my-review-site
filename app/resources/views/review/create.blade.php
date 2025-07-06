@extends('layouts.app')

@section('title', 'レビュー投稿')

@section('content')
<div class="container" style="max-width: 720px;">
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
        {{-- 店舗名（readonly） --}}
        <div class="mb-3">
            <label class="form-label">店舗名</label>
            <input type="text" class="form-control" value="{{ $shop->name }}" readonly>
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
        </div>

        {{-- タイトル --}}
        <div class="mb-3">
            <label for="title" class="form-label">タイトル</label>
            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror"
                   value="{{ old('title') }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- スコア --}}
        <div class="mb-3">
            <label for="score" class="form-label">評価（1〜5）</label>
            <select id="score" name="score" class="form-select @error('score') is-invalid @enderror" required>
                <option value="">選択してください</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('score') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            @error('score')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 内容 --}}
        <div class="mb-3">
            <label for="content" class="form-label">レビュー内容</label>
            <textarea id="content" name="content" rows="5" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 画像アップロード --}}
        <div class="mb-3">
            <label for="image" class="form-label">画像（任意）</label>
            <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- 送信ボタン --}}
        <div class="text-end">
            <button type="submit" class="btn btn-primary">投稿する</button>
        </div>
    </form>
</div>
@endsection
