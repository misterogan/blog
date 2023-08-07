<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function create(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $comment = Comment::create([
            'user_id' => auth()->user()->id,
            'blog_post_id' => $id,
            'content' => $request->description,
        ]);

        return response()->json(['message' => 'Comment created successfully'], 201);
    }

    public function update(Request $request, $commentId)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $comment = Comment::findOrFail($commentId);
        $comment->update([
            'content' => $request->description,
        ]);

        return response()->json(['message' => 'Comment updated successfully'], 200);
    }

    public function delete($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }
}
