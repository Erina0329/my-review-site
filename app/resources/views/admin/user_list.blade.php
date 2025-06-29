@extends('layouts.app')

@section('title', 'ユーザー一覧（管理）')

@section('content')
<div class="container">
    <h1 class="mb-4">ユーザー一覧</h1>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>登録日</th>
                <th>違反報告数</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>{{ $user->violations_count }}</td>
                <td>
                    <a href="{{ route('admin.user_detail', ['id' => $user->id]) }}" class="btn btn-sm btn-outline-primary">詳細</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
