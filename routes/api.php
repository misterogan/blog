<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    //blog
    Route::post('blog-posts', [BlogPostController::class, 'create']);
    Route::put('blog-posts/{id}', [BlogPostController::class, 'update']);
    Route::delete('blog-posts/{id}', [BlogPostController::class, 'delete']);
    Route::get('blog-posts', [BlogPostController::class, 'index']);
    Route::get('blog-posts/filter', [BlogPostController::class, 'filter']);

    //comment
    Route::post('blog-posts/{id}/comments', [CommentController::class, 'create']);
    Route::put('comments/{id}', [CommentController::class, 'update']);
    Route::delete('comments/{id}', [CommentController::class, 'delete']);

    // Like and dislike a blog post
    Route::post('blog-posts/{id}/like', [LikeController::class, 'likeBlogPost']);
    Route::post('blog-posts/{id}/dislike', [LikeController::class, 'dislikeBlogPost']);

    // Like and dislike a comment
    Route::post('comments/{id}/like', [LikeController::class, 'likeComment']);
    Route::post('comments/{id}/dislike', [LikeController::class, 'dislikeComment']);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
