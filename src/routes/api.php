<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Route::apiResource('posts', PostController::class);

Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
Route::put('/posts/{post}/comments/{id}', [CommentController::class, 'update']);
Route::delete('/posts/{post}/comments/{id}', [CommentController::class, 'destroy']);
