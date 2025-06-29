@extends('layouts.app')

@section('title', 'ブックマーク一覧')

@section('content')
<div class="container">
    <h1 class="mb-4">ブックマーク一覧</h1>

    @if ($bookmarks->isEmpty())
        <p>ブックマークはまだ登録されていません。</p>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($bookmarks as $bookmark)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ $bookmark->shop->image }}" class="card-img-top" alt="{{ $bookmark->shop->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $bookmark->shop->name }}</h5>
                            <p class="card-text">{{ $bookmark->shop->address }}</p>
                            <p class="card-text">平均点：{{ number_format($bookmark->shop->average_score, 1) }} / 5</p>
                            <a href="{{ route('shops.show', $bookmark->shop->id) }}" class="btn btn-outline-primary btn-sm">店舗詳細</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <a href="{{ route('user.mypage') }}" class="btn btn-secondary mt-4">マイページへ戻る</a>
</div>
@endsection
