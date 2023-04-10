<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function list()
    {
        $posts = Post::all();

        return view('post.index', compact('posts'));
    }

    public function create(Request $request)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        Post::create($data);
        return response()->json(['success' => "Data Saved Successfully"]);
    }

    public function edit($id)
    {
        $data = Post::findOrFail($id);

        return response()->json(['result' => $data]);
    }

    public function update(Request $request, $id)
    {
        Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
        ];

        Post::where('id', $id)->update($data);
        return response()->json(['success' => "Data Updated Successfully"]);
    }

    public function delete($id)
    {
        Post::findOrFail($id)->delete();

        return redirect()->route('post.list')->with('success', "Data Deleted Successfully");
    }
}
