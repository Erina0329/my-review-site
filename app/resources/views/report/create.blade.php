@extends('layouts.app')

@section('title', '違反報告')

@section('content')
<div class="container">
    <h1 class="mb-4">違反報告</h1>

    <p><strong>対象レビュー：</strong> {{ $review->title }}</p>
    <p>{{ $review->content }}</p>
    <form action="{{ route('violations.store') }}" method="POST">
        @csrf
        <input type="hidden" name="review_id" value="{{ $review->id }}">
        <input type="hidden" name="redirect_to" value="{{ url()->previous() }}"> {{-- 直前のURLを渡す --}}

        <div class="mb-3">
            <label for="reason">違反報告理由</label>
            <textarea name="reason" id="reason" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-danger">違反報告する</button>
    </form>

</div>
@endsection
