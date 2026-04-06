<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan with('user') untuk efisiensi query (eager loading)
        $blogs = Blog::with('user')->latest()->paginate(10);
        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_id' => 'required|string|max:255',
            'excerpt_en' => 'required',
            'excerpt_id' => 'required',
            'content_en' => 'required',
            'content_id' => 'required',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags' => 'nullable|string',
        ]);

        // 1. Handle Tags (Ubah string koma menjadi array)
        $validated['tags'] = $request->tags
            ? array_map('trim', explode(',', $request->tags))
            : [];

        // 2. Handle Image Upload
        if ($request->hasFile('image')) {
            // Simpan file ke storage/app/public/blogs
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        // 3. Generate Slug (Unik menggunakan time())
        $validated['slug'] = Str::slug($validated['title_en']) . '-' . time();

        // 4. Set Author
        $validated['user_id'] = auth()->id();

        // 5. Handle Status Publish
        $validated['is_published'] = $request->has('is_published');
        $validated['published_at'] = $request->has('is_published') ? now() : null;

        Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_id' => 'required|string|max:255',
            'excerpt_en' => 'required',
            'excerpt_id' => 'required',
            'content_en' => 'required',
            'content_id' => 'required',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags' => 'nullable|string',
        ]);

        // 1. Handle Tags
        $validated['tags'] = $request->tags
            ? array_map('trim', explode(',', $request->tags))
            : [];

        // 2. Handle Image Update
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($blog->image && Storage::disk('public')->exists($blog->image)) {
                Storage::disk('public')->delete($blog->image);
            }
            // Upload gambar baru
            $validated['image'] = $request->file('image')->store('blogs', 'public');
        }

        // 3. Handle Slug (Opsional: Uncomment baris di bawah jika ingin slug berubah saat judul diubah)
        // $validated['slug'] = Str::slug($validated['title_en']) . '-' . time();

        // 4. Handle Status Publish
        $validated['is_published'] = $request->has('is_published');

        // Set published_at HANYA jika baru dipublish (sebelumnya draft, sekarang dicentang)
        if ($request->has('is_published') && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        // Hapus gambar dari storage
        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully.');
    }
}
