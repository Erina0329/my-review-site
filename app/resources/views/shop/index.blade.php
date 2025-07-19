@extends('layouts.app')

@section('title', '店舗一覧')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center fw-bold">飲食店一覧</h1>

    {{-- 検索フォーム --}}
    <form method="GET" action="{{ route('shops.index') }}" class="row g-3 mb-4">
        <div class="col-md-6">
            <input type="text" name="keyword" class="form-control" placeholder="店舗名・住所・レビューで検索" value="{{ request('keyword') }}">
        </div>
        <div class="col-md-3">
            <select name="score" class="form-select">
                <option value="">レビュー点で絞り込み</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ request('score') == $i ? 'selected' : '' }}>{{ $i }} 点</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3">
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
                        {{-- 店舗画像（仮画像） --}}
                        <!-- <img src="{{ asset($shop->image_path ?? 'images/no_image.jpg') }}" class="card-img-top" alt="{{ $shop->name }}"> -->
                        <img src="{{ asset('storage/' . $shop->image_path) }}" alt="店舗画像" class="card-img-top">

                        <div class="card-body">
                            <h5 class="card-title">{{ $shop->name }}</h5>

                            {{-- 平均スコア --}}
                            @php
                                $average = $shop->reviews->avg('score');
                            @endphp
                            <p class="mb-1">
                                <strong>平均レビュー点：</strong>
                                {{ $average ? number_format($average, 1) . ' / 5.0' : 'レビューなし' }}
                            </p>

                            <p class="mb-1"><strong>住所：</strong>{{ $shop->address }}</p>
                        </div>

                        <div class="card-footer bg-white border-top-0 text-end">
                            <a href="{{ route('shops.show', $shop->id) }}" class="btn btn-outline-primary btn-sm">詳細を見る</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
