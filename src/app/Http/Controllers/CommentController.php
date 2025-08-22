<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
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
     * 특정 게시글의 댓글 목록
     */
    public function index(Request $request, $postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return $this->response(false, 'Post not found', null, 404);
        }

        // 요청에서 per_page 값 가져오기 (없으면 10개)
        $perPage = $request->get('per_page', 10);
        $comments = $post->comments()->orderBy('id', 'desc')->paginate($perPage);

        return $this->response(true, 'Comment list retrieved successfully', $comments);
    }

    /**
     * 댓글 생성
     */
    public function store(Request $request, $postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return $this->response(false, 'Post not found', null, 404);
        }

        $validator = Validator::make($request->all(), [
            'author'  => 'required|string|max:100',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->response(false, 'Validation Error', $validator->errors(), 422);
        }

        $comment = $post->comments()->create([
            'author'  => $request->author,
            'content' => $request->content,
        ]);

        return $this->response(true, 'Comment created successfully', $comment, 201);
    }

    /**
     * 댓글 수정
     */
    public function update(Request $request, $postId, $id)
    {
        $post = Post::find($postId);
        if (!$post) {
            return $this->response(false, 'Post not found', null, 404);
        }

        $comment = $post->comments()->find($id);
        if (!$comment) {
            return $this->response(false, 'Comment not found', null, 404);
        }

        $validator = Validator::make($request->all(), [
            'author'  => 'sometimes|required|string|max:100',
            'content' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return $this->response(false, 'Validation Error', $validator->errors(), 422);
        }

        $comment->update($request->only(['author', 'content']));

        return $this->response(true, 'Comment updated successfully', $comment);
    }

    /**
     * 댓글 삭제
     */
    public function destroy($postId, $id)
    {
        $post = Post::find($postId);
        if (!$post) {
            return $this->response(false, 'Post not found', null, 404);
        }

        $comment = $post->comments()->find($id);
        if (!$comment) {
            return $this->response(false, 'Comment not found', null, 404);
        }

        $comment->delete();

        return $this->response(true, 'Comment deleted successfully');
    }
}
