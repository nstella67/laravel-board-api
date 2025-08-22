<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Post;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 고정된 댓글 더미 데이터
        $post = Post::first();  // 게시글 중 가장 작은 id
        if ($post) {
            Comment::create([
                'post_id' => $post->id,
                'content' => '첫 댓글입니다.',
                'author'  => '관리자',
            ]);

            Comment::create([
                'post_id' => $post->id,
                'content' => '두 번째로 작성한 댓글입니다.',
                'author'  => '이누리',
            ]);
        }

        // 랜덤 댓글 50개 생성
        Comment::factory()->count(50)->create();
    }
}
