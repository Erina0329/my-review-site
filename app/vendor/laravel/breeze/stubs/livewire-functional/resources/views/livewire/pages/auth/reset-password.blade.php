@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="w-100" style="max-width: 480px;">
        <h2 class="mb-4 text-center fw-bold">パスワードリセット</h2>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                    class="form-control @error('email') is-invalid @enderror" required autofocus>

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">新しいパスワード</label>
                <input id="password" type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror" required>

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">パスワード（確認）</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                    class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">パスワードを更新</button>
            </div>
        </form>
    </div>
</div>
@endsection
