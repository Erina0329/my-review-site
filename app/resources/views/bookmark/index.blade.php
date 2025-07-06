@extends('layouts.app')

@section('title', 'ブックマーク一覧')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center fw-bold">ブックマーク一覧</h1>

    @forelse ($bookmarks as $bookmark)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $bookmark->shop->name }}</h5>
                <p class="card-text">{{ $bookmark->shop->address }}</p>
                <a href="{{ route('shops.show', $bookmark->shop->id) }}" class="btn btn-outline-primary btn-sm">詳細を見る</a>
            </div>
        </div>
    @empty
        <p class="text-center">ブックマークはまだありません。</p>
    @endforelse
</div>
@endsection
