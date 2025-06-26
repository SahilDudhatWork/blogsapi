<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // List all blogs
    public function index()
    {
        $blogs = Blog::all();
        return response()->json($blogs);
    }

    // Create a new blog
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'slug' => 'required|string|unique:blogs,slug',
            'title' => 'required|string|max:255',
            'short_description' => 'string',
            'content' => 'string',
            'image_path' => 'nullable|string',
            'table_of_content' => 'nullable|array',
        ]);

        $blog = Blog::create($validatedData);
        return response()->json($blog, 201);
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
