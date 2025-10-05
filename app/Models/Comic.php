<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    /** @use HasFactory<\Database\Factories\ComicsFactory> */
    use HasFactory;

    protected $fillable = [
        'image',
        'title',
        'author',
        'publisher',
        'description'
    ];

    public function liked()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at', 'desc');
    }
}
