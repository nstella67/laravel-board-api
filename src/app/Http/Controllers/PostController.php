<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * 공통 JSON 응답 포맷
     */
    private function response($success, $message, $data = null, $code = 200)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'    => $data
        ], $code);
    }

    /**
     * 게시글 목록 (페이지네이션)
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10); // 없으면 기본 10
        $posts = Post::orderBy('created_at', 'desc')->paginate($perPage);
        // $posts = Post::orderBy('created_at', 'desc')->paginate(5);

        return $this->response(true, 'Post list retrieved successfully', [
            'items' => $posts->items(),
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
            ]
        ]);
    }

    /**
     * 게시글 생성
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'author'  => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return $this->response(false, 'Validation Error', $validator->errors(), 422);
        }

        $post = Post::create([
            'title'   => $request->title,
            'content' => $request->content,
            'author'  => $request->author,
        ]);

        return $this->response(true, 'Post created successfully', $post, 201);
    }

    /**
     * 게시글 상세조회
     */
    public function show($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->response(false, 'Post not found', null, 404);
        }

        return $this->response(true, 'Post retrieved successfully', $post);
    }

    /**
     * 게시글 수정
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->response(false, 'Post not found', null, 404);
        }

        $validator = Validator::make($request->all(), [
            'title'   => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'author'  => 'sometimes|required|string|max:100',
        ]);

        if ($validator->fails()) {
            return $this->response(false, 'Validation Error', $validator->errors(), 422);
        }

        $post->update($request->only(['title', 'content', 'author']));

        return $this->response(true, 'Post updated successfully', $post);
    }

    /**
     * 게시글 삭제
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->response(false, 'Post not found', null, 404);
        }

        $post->delete();

        return $this->response(true, 'Post deleted successfully');
    }
}
