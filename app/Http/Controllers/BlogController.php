<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the blog posts.
     */
    public function index(Request $request)
    {
        $query = Blog::with('user')
            ->where('is_published', true);

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        // Search by keyword
        if ($request->has('search') && $request->search) {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('title_en', 'like', "%{$keyword}%")
                  ->orWhere('title_id', 'like', "%{$keyword}%")
                  ->orWhere('excerpt_en', 'like', "%{$keyword}%")
                  ->orWhere('excerpt_id', 'like', "%{$keyword}%");
            });
        }

        $blogs = $query->latest('published_at')
            ->paginate(9);

        return view('pages.blog.index', compact('blogs'));
    }

    /**
     * Display the specified blog post.
     */
    public function show($slug)
    {
        $blog = Blog::with('user')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment view count
        $blog->increment('views');

        return view('pages.blog.show', compact('blog'));
    }
}
