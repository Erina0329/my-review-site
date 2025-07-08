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
use App\Http\Controllers\MainController;
use App\Http\Controllers\ShopAdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// トップページ
Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('shops.index')        // ログイン済み → 店舗一覧
        : redirect()->route('guest.home');        // ゲスト → ゲスト用トップページ
})->name('home');

// ゲスト用ホーム
Route::get('/guest-home', [MainController::class, 'index'])
    ->middleware('guest')
    ->name('guest.home');

// ログイン・ログアウト・登録
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->middleware('guest')->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->middleware('guest')->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

// ログアウト
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Breezeダッシュボード（不要なら削除OK）
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ▼ 共通マイページ（ロールに応じてBlade内で切り替え）
Route::middleware(['auth'])->get('/mypage', function () {
    return view('mypage');
})->name('mypage');

// ▼ 一般ユーザー機能（role = 1）
Route::middleware(['auth'])->group(function () {
    Route::get('/mypage/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/mypage/update', [UserController::class, 'update'])->name('user.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mypage/reviews', [ReviewController::class, 'myReviews'])->name('reviews.my');
    Route::resource('reviews', ReviewController::class)->except(['index', 'show']);

    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{shop}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');

    Route::get('/report/create', [ViolationController::class, 'create'])->name('violations.create');
    Route::post('/report', [ViolationController::class, 'store'])->name('violations.store');
});

// ▼ 店舗管理ユーザー専用（role = 2）
Route::middleware(['auth'])->prefix('shop-admin')->name('shop_admin.')->group(function () {
    Route::get('/reviews', [ShopAdminController::class, 'reviews'])->name('reviews');
    Route::get('/edit', [ShopAdminController::class, 'edit'])->name('edit');
});

// ▼ 管理ユーザー専用（role = 0）
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminController::class, 'index'])->name('users.index');

    Route::get('/user_list', [AdminController::class, 'userList'])->name('user_list');
    Route::get('/user_detail/{id}', [AdminController::class, 'userDetail'])->name('user_detail');
    Route::get('/post_list', [AdminController::class, 'postList'])->name('post_list');
    Route::get('/post_detail/{id}', [AdminController::class, 'postDetail'])->name('post_detail');
    Route::get('/review_detail/{id}', [AdminController::class, 'reviewDetail'])->name('review_detail');
    Route::get('/users', [AdminController::class, 'userList'])->name('users.index');
    Route::get('/posts', [AdminController::class, 'postList'])->name('posts.index');
    Route::get('/posts/{id}', [AdminController::class, 'postDetail'])->name('posts.show');
});

// ▼ 店舗閲覧（全ユーザーアクセス可）
Route::resource('shops', ShopController::class)->only(['index', 'show']);

// ▼ レビュー閲覧（全ユーザーアクセス可）
Route::resource('reviews', ReviewController::class)->only(['index', 'show']);


require __DIR__.'/auth.php';
