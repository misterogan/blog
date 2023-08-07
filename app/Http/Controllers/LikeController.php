<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Http\Request;


class LikeController extends Controller
{
    public function likeBlogPost(Request $request, $id)
    {
        $blogPost = BlogPost::findOrFail($id);
        $blogPost->increment('likes');

        return response()->json(['message' => 'Liked the blog post'], 200);
    }

    public function dislikeBlogPost(Request $request, $id)
    {
        $blogPost = BlogPost::findOrFail($id);
        $blogPost->increment('dislikes');

        return response()->json(['message' => 'Disliked the blog post'], 200);
    }

    public function likeComment(Request $request, $id)
    {

        $comment = Comment::findOrFail($id);
        $comment->increment('likes');

        return response()->json(['message' => 'Liked the comment'], 200);
    }

    public function dislikeComment(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->increment('dislikes');

        return response()->json(['message' => 'Disliked the comment'], 200);
    }
}
