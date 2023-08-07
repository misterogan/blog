<?php

namespace App\Http\Controllers;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class BlogPostController extends Controller
{
    public function index()
    {
        $blogPosts = BlogPost::all();
        return response()->json($blogPosts, 200);
    }
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $blogPost = BlogPost::create([
            'title' => $request->title,
            'content' => $request->description,
            'author_id' => auth()->user()->id,
            'published_date' => now(), // You can adjust this
            'status' => 'draft', // You can adjust this
        ]);

        return response()->json(['message' => 'Blog post created successfully'], 201);
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $blogPost = BlogPost::findOrFail($id);
        $this->authorize('update', $blogPost);
        $blogPost->update([
            'title' => $request->title,
            'content' => $request->description,
        ]);

        return response()->json(['message' => 'Blog post updated successfully'], 200);
    }

    public function delete($id)
    {

        $blogPost = BlogPost::where('id',$id)->first();
        if($blogPost){
            $blogPost->delete();
            return response()->json(['message' => 'Blog post deleted successfully'], 200);
        }else{
            return response()->json(['errors' => 'Data not available'], 404);
        }

    }

    public function filter(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $query = BlogPost::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('author')) {
            $query->where('author_id', $request->author);
        }

        if ($request->has('start_date')) {
            $query->where('published_date', '>=', Carbon::parse($request->start_date));
        }

        if ($request->has('end_date')) {
            $query->where('published_date', '<=', Carbon::parse($request->end_date));
        }

        $filteredPosts = $query->get();

        return response()->json($filteredPosts, 200);
    }
}
