@extends('layouts.app')

@section('title', 'レビュー一覧（管理）')

@section('content')
<div class="container">
    <h1 class="mb-4">レビュー一覧</h1>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>投稿者</th>
                <th>店舗名</th>
                <th>タイトル</th>
                <th>スコア</th>
                <th>違反報告数</th>
                <th>投稿日</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $review)
                <tr @if ($review->violations->count() > 0) class="table-danger" @endif>
                    <td>{{ $review->id }}</td>
                    <td>{{ $review->user->name }}</td>
                    <td>{{ $review->shop->name }}</td>
                    <td>{{ $review->title }}</td>
                    <td>★{{ $review->score }}</td>
                    <td>{{ $review->violations->count() }}</td>
                    <td>{{ $review->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.post_detail', ['id' => $review->id]) }}" class="btn btn-sm btn-outline-secondary">詳細</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
