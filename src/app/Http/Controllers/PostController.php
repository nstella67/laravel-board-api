<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * 게시글 목록 (페이지네이션)
     */
    public function index()
    {
        $posts = Post::paginate(10); // 10개씩 페이지네이션
        return response()->json($posts);
    }

    /**
     * 게시글 생성
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'author'  => 'required|string|max:100',
        ]);

        $post = Post::create($validated);

        return response()->json($post, 201);
    }

    /**
     * 게시글 상세조회
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }

    /**
     * 게시글 수정
     */
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'   => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'author'  => 'sometimes|string|max:100',
        ]);

        $post->update($validated);

        return response()->json($post);
    }

    /**
     * 게시글 삭제
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
