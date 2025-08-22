<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    
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
