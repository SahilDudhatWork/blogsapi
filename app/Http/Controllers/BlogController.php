<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    // List all blogs
    public function index()
    {
        try {
            $blogs = Blog::paginate(9);
            return $this->responseSuccess(['blogs' => $blogs], 'Blogs fetched successfully');
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 404);
        }
    }

    // Create a new blog
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'slug' => 'required|string|unique:blogs,slug',
                'title' => 'required|string|max:255',
                'short_description' => 'string',
                'content' => 'string',
                'image_path' => 'nullable|string',
                'table_of_content' => 'nullable|array',
            ]);
            $blog = Blog::create($validatedData);
            return $this->responseSuccess(['blog' => $blog], 'Blog created successfully');
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 404);
        }
    }

    // Show a specific blog
    public function showBySlug(Request $request)
    {
        try {
            $slug = $request->input('slug');
            if (!$slug) {
                return $this->responseError('Invalid blog url', 404);
            }

            $blog = Blog::where('slug', $slug)->first();
            if (!$blog) {
                return $this->responseError('Blog not found', 404);
            }

            return $this->responseSuccess(['blog' => $blog], 'Blog fetched successfully');
        } catch (\Exception $e) {
            return $this->responseError($e->getMessage(), 404);
        }
    }

    // Show a specific blog
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return response()->json($blog);
    }

    // Update a blog
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $validatedData = $request->validate([
            'slug' => 'required|string|unique:blogs,slug,' . $blog->id,
            'title' => 'required|string|max:255',
            'short_description' => 'required|string',
            'content' => 'required|string',
            'image_path' => 'nullable|string',
            'table_of_content' => 'nullable|array',
        ]);

        $blog->update($validatedData);
        return response()->json($blog);
    }

    // Delete a blog
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        return response()->json(null, 204);
    }
}
