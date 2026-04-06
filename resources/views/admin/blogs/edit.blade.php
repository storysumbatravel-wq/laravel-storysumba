@extends('layouts.admin')

@section('title', 'Edit Blog Post')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.blogs.index') }}" class="inline-flex items-center gap-2 text-luxury-600 hover:text-red-600 transition-colors text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Posts
    </a>
</div>

<div class="bg-white rounded-2xl shadow-luxury p-8">
    <h1 class="text-2xl font-display font-bold text-luxury-900 mb-6">Edit Post</h1>

    {{-- BLOK NOTIFIKASI ERROR (SANGAT PENTING) --}}
    @if ($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-medium">
                        There were some problems with your input:
                    </p>
                    <ul class="mt-1 text-sm text-red-600 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.blogs.update', $blog->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- IMAGE UPLOAD -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-luxury-700 mb-3">
                Featured Image
            </label>

            <div id="dropArea"
                class="relative flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-luxury-300 rounded-2xl cursor-pointer bg-luxury-50 hover:bg-luxury-100 transition">

                <input type="file"
                    name="image"
                    id="imageInput"
                    accept="image/*"
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">

                <!-- Upload Placeholder -->
                <div id="uploadPlaceholder" class="text-center @if($blog->image) hidden @endif">
                    <svg class="mx-auto w-10 h-10 text-luxury-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M7 16V4m0 0L3 8m4-4l4 4M17 20v-8m0 0l-4 4m4-4l4 4"/>
                    </svg>
                    <p class="text-sm text-luxury-600">
                        Drag & drop image here or <span class="text-red-500 font-semibold">click to browse</span>
                    </p>
                    <p class="text-xs text-luxury-400 mt-1">JPG, PNG, WEBP (max 2MB)</p>
                </div>

                <!-- Preview -->
                <img id="imagePreview"
                    src="{{ $blog->image ? asset('storage/' . $blog->image) : '' }}"
                    class="absolute inset-0 w-full h-full object-cover rounded-2xl @if(empty($blog->image)) hidden @endif">
            </div>
            <p class="text-xs text-luxury-400 mt-2">Kosongkan jika tidak ingin mengganti gambar.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- English Content -->
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-luxury-900 border-b border-luxury-100 pb-2">English Content</h2>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Title (English) *</label>
                    <input type="text" name="title_en" value="{{ old('title_en', $blog->title_en) }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Excerpt (English) *</label>
                    <textarea name="excerpt_en" rows="2" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none">{{ old('excerpt_en', $blog->excerpt_en) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Content (English) *</label>
                    <textarea name="content_en" rows="8" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none">{{ old('content_en', $blog->content_en) }}</textarea>
                </div>
            </div>

            <!-- Indonesian Content -->
            <div class="space-y-6">
                <h2 class="text-lg font-semibold text-luxury-900 border-b border-luxury-100 pb-2">Indonesian Content</h2>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Title (Indonesian) *</label>
                    <input type="text" name="title_id" value="{{ old('title_id', $blog->title_id) }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Excerpt (Indonesian) *</label>
                    <textarea name="excerpt_id" rows="2" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none">{{ old('excerpt_id', $blog->excerpt_id) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-luxury-700 mb-2">Content (Indonesian) *</label>
                    <textarea name="content_id" rows="8" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none">{{ old('content_id', $blog->content_id) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Settings -->
        <div class="mt-8 pt-6 border-t border-luxury-100 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-luxury-700 mb-2">Category *</label>
                <input type="text" name="category" value="{{ old('category', $blog->category) }}" required class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
            </div>

            {{-- PERBAIKAN ARRAY TO STRING --}}
            <div>
                <label class="block text-sm font-medium text-luxury-700 mb-2">Tags</label>
                <input type="text" name="tags" value="{{ old('tags', is_array($blog->tags) ? implode(', ', $blog->tags) : $blog->tags) }}" class="w-full px-4 py-3 bg-luxury-50 border border-luxury-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
            </div>

            <div class="flex items-end pb-1">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_published" {{ old('is_published', $blog->is_published) ? 'checked' : '' }} class="w-5 h-5 text-red-600 border-luxury-300 rounded focus:ring-red-500">
                    <span class="text-luxury-700 font-medium">Published</span>
                </label>
            </div>
        </div>

        <!-- Submit -->
        <div class="mt-8 flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-red-500 text-white rounded-xl font-semibold hover:bg-red-600 transition-colors">
                Update Post
            </button>
            <a href="{{ route('admin.blogs.index') }}" class="px-6 py-3 bg-luxury-100 text-luxury-700 rounded-xl font-medium hover:bg-luxury-200 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    // JavaScript Preview Logic
    const dropArea = document.getElementById('dropArea');
    const imageInput = document.getElementById('imageInput');
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');

    imageInput.addEventListener('change', handleFile);

    dropArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropArea.classList.add('border-red-500', 'bg-red-50');
    });

    dropArea.addEventListener('dragleave', () => {
        dropArea.classList.remove('border-red-500', 'bg-red-50');
    });

    dropArea.addEventListener('drop', (e) => {
        e.preventDefault();
        dropArea.classList.remove('border-red-500', 'bg-red-50');
        imageInput.files = e.dataTransfer.files;
        handleFile();
    });

    function handleFile() {
        const file = imageInput.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection
