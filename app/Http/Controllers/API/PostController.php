<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        try {
            $posts = Post::with(['user', 'category'])->get();

            return response()->json([
                'success' => true,
                'message' => 'Success when get Posts data',
                $posts
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error when get Posts data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function show(PostRequest $request)
    {
        try {
            $post = Post::with(['user', 'category'])->findOrFail($request->id);

            if (!$post) {
                return response()->json([
                    'success' => true,
                    'messages' => 'Success get Post data',
                    'data' => $post
                ], 200);
            }
            return response()->json($post);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error when get Post data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function create(PostRequest $request)
    {
        try {
            $input = $request->all();
            // $input['user_id'] = Auth::user()->id;
            $insert = Post::create($input);

            return response()->json([
                'success' => true,
                'message' => 'Post data has been add',
                'data' => $insert
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error when add Post data',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function update(PostRequest $request)
    {
        try {
            $post = Post::findOrFail($request->id);

            $input = $request->all();
            $post->fill($input);
            $post->save();

            return response()->json([
                'success' => true,
                'message' => 'Post data has been updated',
                'data' => $post
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(PostRequest $request)
    {
        try {
            $post = Post::findOrFail($request->id);
            $post->delete();

            return response()->json(['message' => 'Post deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
