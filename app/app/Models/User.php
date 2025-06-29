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
    ];

    /**
     * ユーザーが投稿したレビュー
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * ユーザーが登録したブックマーク
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * 店舗ユーザーが持つ店舗
     */
    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    /**
     * ユーザーが通報した違反
     */
    public function violations()
    {
        return $this->hasMany(Violation::class);
    }
}
