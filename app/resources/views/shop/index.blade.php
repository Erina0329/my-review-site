@extends('layouts.app')

@section('title', '店舗一覧')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center fw-bold">飲食店一覧</h1>

    <div class="mb-3 text-end">
        <a href="{{ route('mypage') }}" class="btn btn-success">マイページ</a>
    </div>
    <div class="mb-3 text-end">
        <a href="{{ route('bookmarks.index') }}" class="btn btn-success">ブックマーク一覧を見る</a>
    </div>

    {{-- 検索フォーム --}}
    <form method="GET" action="{{ route('shops.index') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <input type="text" name="keyword" class="form-control"
                placeholder="店舗名・住所・レビューで検索" value="{{ request('keyword') }}">
        </div>

        <div class="col-md-2">
            <input type="number" name="min_score" class="form-control"
                placeholder="最低点" min="1" max="5" value="{{ request('min_score') }}">
        </div>

        <div class="col-md-2">
            <input type="number" name="max_score" class="form-control"
                placeholder="最高点" min="1" max="5" value="{{ request('max_score') }}">
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">検索</button>
        </div>
    </form>

    {{-- 店舗一覧 --}}
    @if($shops->isEmpty())
        <p class="text-center">該当する店舗が見つかりませんでした。</p>
    @else
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($shops as $shop)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        {{-- 店舗画像 --}}
                        <img src="{{ asset('storage/' . $shop->image_path) }}" 
                             alt="店舗画像" class="card-img-top">

                        <div class="card-body">
                            <h5 class="card-title">{{ $shop->name }}</h5>

                            {{-- 平均スコア（Controllerで計算したavg_scoreを使用） --}}
                            <p class="mb-1">
                                <strong>平均レビュー点：</strong>
                                {{ $shop->avg_score !== null && $shop->avg_score > 0 
                                    ? number_format($shop->avg_score, 1) . ' / 5.0' 
                                    : 'レビューなし' }}
                            </p>

                            <p class="mb-1"><strong>住所：</strong>{{ $shop->address }}</p>
                        </div>

                        <div class="card-footer bg-white border-top-0 text-end">
                            <a href="{{ route('shops.show', $shop->id) }}" 
                               class="btn btn-outline-primary btn-sm">詳細を見る</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
