<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * 一括代入可能な属性
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * JSONに含めない属性
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 型変換する属性
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'integer',
    ];

    /**
     * ユーザーが投稿したレビュー
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * ユーザーが登録したブックマーク（店舗）
     */
    public function bookmarkedShops()
    {
        return $this->belongsToMany(Shop::class, 'bookmarks');
    }

    /**
     * 店舗ユーザーが所有する店舗
     */
    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    /**
     * ユーザーが通報した違反（通報者として）
     */
    public function violations()
    {
        return $this->hasMany(Violation::class);
    }

    /**
     * 自分のレビューに対する違反報告（集計用）
     */
    public function violationReports()
    {
        return $this->hasManyThrough(
            \App\Models\Violation::class,
            \App\Models\Review::class,
            'user_id',      // Review.user_id = User.id
            'review_id',    // Violation.review_id = Review.id
            'id',           // User.id
            'id'            // Review.id
        );
    }

    /**
     * ロール：管理者かどうか
     */
    public function isAdmin()
    {
        return $this->role === 0;
    }

    /**
     * ロール：店舗管理者かどうか
     */
    public function isShopUser()
    {
        return $this->role === 2;
    }

    /**
     * ロール：一般ユーザーかどうか
     */
    public function isGeneralUser()
    {
        return $this->role === 1;
    }
}
