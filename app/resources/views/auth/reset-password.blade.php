@extends('layouts.app')

@section('title', 'パスワード再設定')

@section('content')
<div class="container">
    <h1 class="mb-4">新しいパスワードの設定</h1>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <input type="hidden" name="email" value="{{ $request->email }}">

        <div class="mb-3">
            <label for="password" class="form-label">新しいパスワード</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">パスワード（確認）</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">パスワードを再設定</button>
    </form>
</div>
@endsection
