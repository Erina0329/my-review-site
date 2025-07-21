@extends('layouts.app')

@section('title', 'ユーザー一覧（管理）')

@section('content')
<div class="container">
    <h1 class="mb-4">ユーザー一覧</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ユーザー名</th>
                <th>メールアドレス</th>
                <th>非表示投稿数</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->hidden_reviews_count }}</td>
                <td>
                    
                    @if ($user->deleted_at)
                    <span class="badge bg-danger">利用停止中</span>
                    @else
                        <a href="{{ route('admin.user_detail', $user->id) }}" class="btn btn-outline-primary btn-sm">詳細</a>
                        <form action="{{ route('admin.user_suspend', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('このユーザーを停止しますか？')">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-danger btn-sm">利用停止</button>
                        </form>
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
