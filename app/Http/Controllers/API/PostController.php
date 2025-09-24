<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['posts'] = Post::all();

        return response()->json([
            'status' => 'true',
            'message' => 'All Post Data',
            'data' => '$data'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'required|mimes:png,jpg,jpeg,gif|max:2048', // fixed "mimes"
            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validateUser->errors()->all()
            ], 422);
        }

        // ✅ Handle file upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $imageName);
        }

        // ✅ Save post in DB
        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Post created successfully',
            'data' => $post
        ], 201);
    }


    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $post
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateUser = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
                'image' => 'nullable|mimes:png,jpg,jpeg,gif|max:2048', // image optional rakha
            ]
        );

        if ($validateUser->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validateUser->errors()->all()
            ], 422);
        }

        // ✅ Find post
        $post = Post::find($id);
        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found'
            ], 404);
        }

        // ✅ Default image = old one
        $imageName = $post->image;

        // ✅ If new image uploaded, replace old
        if ($request->hasFile('image')) {
            // optional: delete old file if exists
            if ($post->image && file_exists(public_path('uploads/' . $post->image))) {
                unlink(public_path('uploads/' . $post->image));
            }

            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $imageName);
        }

        // ✅ Update record
        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Post updated successfully',
            'data' => $post
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the post by ID
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                'status' => 404,
                'message' => 'Post not found'
            ], 404);
        }

        // If post has an image, delete it from storage
        if ($post->image && file_exists(public_path('images/' . $post->image))) {
            unlink(public_path('images/' . $post->image));
        }

        // Delete the post from DB
        $post->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Post deleted successfully'
        ], 200);
    }
}
