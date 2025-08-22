<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'author',
    ];

    /**
     * Post(게시글) ↔ Comment(댓글) 관계
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
