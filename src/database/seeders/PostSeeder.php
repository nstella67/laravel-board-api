<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 고정된 더미 데이터
        Post::create([
            'title'   => '테스트 게시글 1',
            'content' => '첫 번째 게시글입니다.',
            'author'  => '관리자',
        ]);

        Post::create([
            'title'   => '테스트 게시글 2',
            'content' => '두 번째 게시글입니다.',
            'author'  => '이누리',
        ]);

        Post::create([
            'title'   => '테스트 게시글 3',
            'content' => '세 번째 게시글입니다.',
            'author'  => '이누리',
        ]);

        // 랜덤 데이터 추가
        \App\Models\Post::factory()->count(10)->create();
    }
}
