@extends('layouts.app')

@section('content')
<div class="container">
    <h2>店舗を新規登録</h2>

    <form method="POST" action="{{ route('shops.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">店舗名</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">画像（任意）</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">住所</label>
            <input type="text" name="address" class="form-control" required value="{{ old('address') }}">
        </div>

        <button type="submit" class="btn btn-primary">登録する</button>
    </form>
</div>
@endsection
