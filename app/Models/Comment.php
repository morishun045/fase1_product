<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    protected $fillable = [
        'comic_id', 
        'user_id',
        'comment',
        'rating',
    ];

    public function comic()
    {
        return $this->belongsTo(Comic::class);
    }

    // 🔽 多対1の関係
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
