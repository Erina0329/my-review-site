<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    /**
     * 一括代入可能なカラム
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'image',
        'comment',
    ];

    /**
     * 店舗を所有するユーザー（オーナー）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 店舗に紐づくレビュー
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * 店舗に紐づくブックマーク
     */
    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * この店舗が特定のユーザーにブックマークされているか？
     */
    public function isBookmarkedBy($user)
    {
        return $this->bookmarks->contains('user_id', $user->id);
    }

    /**
     * レビューの平均スコア（アクセサ）
     */
    public function getAverageScoreAttribute()
    {
        return $this->reviews()->avg('score') ?? 0;
    }
}
