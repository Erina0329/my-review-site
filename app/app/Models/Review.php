<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'shop_id', 'title', 'score', 'content', 'image'
    ];

    // 投稿者
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 店舗
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // 違反報告（リレーション用）
    public function violations()
    {
        return $this->hasMany(Violation::class);
    }
}