<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id', 'shop_id', 'review', 'score', 'image_path'
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