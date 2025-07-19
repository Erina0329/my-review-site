@extends('layouts.app')

@section('title', '店舗情報編集')

@section('content')
<div class="container">
    <h2 class="mb-4">店舗情報を編集</h2>

    @foreach ($shops as $shop)
        <div class="border rounded p-3 mb-4">
            <h4>{{ $shop->name }}</h4>

            <form method="POST" action="{{ route('shop_admin.update', $shop->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">店舗名</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $shop->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">住所</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $shop->address) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">店舗画像（任意）</label>
                    @if ($shop->image_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $shop->image_path) }}" alt="店舗画像" style="max-height: 200px;">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">この店舗を更新する</button>
            </form>
        </div>
    @endforeach

    @if ($shops->isEmpty())
        <p>管理している店舗がありません。</p>
    @endif
</div>
@endsection
