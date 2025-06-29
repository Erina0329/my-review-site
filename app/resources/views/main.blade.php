@extends('layouts.app')

@section('title', 'トップページ')

@section('content')
<div class="container">
    <h1 class="mb-4">飲食店レビューサイト</h1>

    {{-- 検索フォーム --}}
    <form action="{{ route('shops.index') }}" method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-8">
                <input type="text" name="keyword" class="form-control" placeholder="タイトル・内容・地域など">
            </div>
            <div class="col-md-2">
                <select name="score" class="form-select">
                    <option value="">点数を選択</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} 点</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">検索</button>
            </div>
        </div>
    </form>

    {{-- 店舗一覧表示 --}}
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($shops as $shop)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ $shop->image }}" class="card-img-top" alt="{{ $shop->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $shop->name }}</h5>
                        <p class="card-text">{{ $shop->address }}</p>
                        <p class="card-text">平均点：{{ number_format($shop->average_score, 1) }} / 5</p>
                        <a href="{{ route('shops.show', $shop->id) }}" class="btn btn-outline-primary btn-sm">詳細を見る</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
