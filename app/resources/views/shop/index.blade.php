@extends('layouts.app')

@section('title', '店舗一覧')

@section('content')
<div class="container">
    <h1 class="mb-4">店舗一覧</h1>

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
