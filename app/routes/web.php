<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ViolationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Webアプリケーションのルーティング設定ファイル
|
*/

// トップページ
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('shops.index')        // ログイン済み → 店舗一覧
        : redirect()->route('guest.home');        // ゲスト → ゲスト用トップページ
})->name('home');

// ゲスト用ホーム
Route::get('/guest-home', function () {
    return view('guest.home'); // Bladeファイル：resources/views/guest/home.blade.php
})->middleware('guest')->name('guest.home');

// ログインページ
Route::get('/login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

// Breeze ダッシュボード（ログイン後）
Route::get('/dashboard', function () {
    return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

// パスワード再設定リンク（表示）
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

// パスワード再設定リンク（送信処理）
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');


// ログインが必要なユーザー機能
Route::middleware('auth')->group(function () {
    // Breeze プロフィール編集
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ユーザーマイページ機能
    Route::get('/mypage', [UserController::class, 'mypage'])->name('user.mypage');
    Route::get('/mypage/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/mypage/update', [UserController::class, 'update'])->name('user.update');

    // ブックマーク機能
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{shop}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');

    // 違反報告機能
    Route::get('/report/create', [ViolationController::class, 'create'])->name('violations.create');
    Route::post('/report', [ViolationController::class, 'store'])->name('violations.store');
});

// 店舗情報（ログイン不要で閲覧可）
Route::resource('shops', ShopController::class)->only(['index', 'show']);

// レビュー機能（ログイン必須）
Route::resource('reviews', ReviewController::class)->middleware(['auth']);

// 管理者用ルート（プレフィックス付き）
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/mypage', [AdminController::class, 'mypage'])->name('mypage');
    Route::get('/user_list', [AdminController::class, 'userList'])->name('user_list');
    Route::get('/user_detail/{id}', [AdminController::class, 'userDetail'])->name('user_detail');
    Route::get('/post_list', [AdminController::class, 'postList'])->name('post_list');
    Route::get('/post_detail/{id}', [AdminController::class, 'postDetail'])->name('post_detail');
    Route::get('/review_detail/{id}', [AdminController::class, 'reviewDetail'])->name('review_detail');

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

});

// Breezeが提供するログイン・登録・リセットなどの認証ルート
require __DIR__.'/auth.php';