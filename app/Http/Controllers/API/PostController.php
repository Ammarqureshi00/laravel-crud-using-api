<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Api\BaseController;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return $this->sendResponse($posts, 'All Post Data');
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
                'image' => 'required|mimes:png,jpg,jpeg,gif|max:2048',
            ]
        );

        if ($validateUser->fails()) {
            return $this->sendError('Validation failed', $validateUser->errors()->all(), 422);
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

        return $this->sendResponse($post, 'Post created successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->sendError('Post not found', [], 404);
        }

        return $this->sendResponse($post, 'Post retrieved successfully');
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
                'image' => 'nullable|mimes:png,jpg,jpeg,gif|max:2048',
            ]
        );

        if ($validateUser->fails()) {
            return $this->sendError('Validation failed', $validateUser->errors()->all(), 422);
        }

        // ✅ Find post
        $post = Post::find($id);
        if (!$post) {
            return $this->sendError('Post not found', [], 404);
        }

        // ✅ Default image = old one
        $imageName = $post->image;

        // ✅ If new image uploaded, replace old
        if ($request->hasFile('image')) {
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

        return $this->sendResponse($post, 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return $this->sendError('Post not found', [], 404);
        }

        // Delete image if exists
        if ($post->image && file_exists(public_path('uploads/' . $post->image))) {
            unlink(public_path('uploads/' . $post->image));
        }

        $post->delete();

        return $this->sendResponse([], 'Post deleted successfully');
    }
}
