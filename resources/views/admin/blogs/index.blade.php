@extends('layouts.admin')

@section('title', 'Manage Blog')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-display font-bold text-luxury-900">Blog Posts</h1>
        <p class="text-luxury-500 text-sm">Manage your articles and stories</p>
    </div>
    <a href="{{ route('admin.blogs.create') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-red-500 text-white rounded-xl font-medium hover:bg-red-600 transition-colors shadow-sm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        New Post
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
    {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-2xl shadow-luxury overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-luxury-50 border-b border-luxury-100">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Title</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Category</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Author</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Date</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-luxury-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-luxury-100">
                @forelse($blogs as $blog)
                <tr class="hover:bg-luxury-50 transition-colors">
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-medium text-luxury-900">{{ $blog->title_en }}</p>
                            <p class="text-sm text-luxury-500 truncate max-w-xs">{{ $blog->excerpt_en }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-luxury-100 text-luxury-600 rounded-full text-xs font-medium">{{ $blog->category }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-luxury-600">{{ $blog->user->name }}</td>
                    <td class="px-6 py-4 text-sm text-luxury-600">{{ $blog->published_at ? $blog->published_at->format('d M Y') : '-' }}</td>
                    <td class="px-6 py-4">
                        @if($blog->is_published)
                        <span class="px-3 py-1 bg-green-100 text-green-600 rounded-full text-xs font-medium">Published</span>
                        @else
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-600 rounded-full text-xs font-medium">Draft</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($blog->is_published)
                            <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" class="p-2 text-luxury-400 hover:text-luxury-600 transition-colors" title="View">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            @endif
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="p-2 text-luxury-400 hover:text-red-600 transition-colors" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form method="POST" action="{{ route('admin.blogs.destroy', $blog->id) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-luxury-400 hover:text-red-500 transition-colors" title="Delete">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-luxury-500">
                        No blog posts found. <a href="{{ route('admin.blogs.create') }}" class="text-red-600 hover:underline">Write your first post</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($blogs->hasPages())
    <div class="px-6 py-4 border-t border-luxury-100">
        {{ $blogs->links() }}
    </div>
    @endif
</div>
@endsection
