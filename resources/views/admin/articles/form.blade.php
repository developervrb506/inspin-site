@extends('admin.layouts.admin')

@section('title', ($article->exists ? 'Edit' : 'Create') . ' Article - INSPIN Admin')
@section('page-title', $article->exists ? 'Edit Article' : 'Create Article')
@section('breadcrumb')
    <a href="{{ route('admin.articles.index') }}">Articles</a>
    <span class="sep">/</span>
    <span>{{ $article->exists ? 'Edit' : 'Create' }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>{{ $article->exists ? 'Edit Article' : 'Create New Article' }}</h2>
        <a href="{{ route('admin.articles.index') }}" class="btn btn-ghost">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Articles
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}" enctype="multipart/form-data">
            @csrf
            @if($article->exists) @method('PUT') @endif

            <div class="form-group">
                <label for="title">Article Title *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" placeholder="Enter article title" required>
                <div class="hint">This will be the main heading of your article</div>
            </div>

            <div class="form-group">
                <label for="excerpt">Excerpt</label>
                <textarea id="excerpt" name="excerpt" rows="3" placeholder="Brief summary of the article...">{{ old('excerpt', $article->excerpt) }}</textarea>
                <div class="hint">Shown in article listings and previews</div>
            </div>

            <div class="form-group">
                <label for="content">Content *</label>
                <div id="editor" style="min-height:300px;border:1px solid #e2e8f0;border-radius:8px;padding:12px;">{{ old('content', $article->content) }}</div>
                <input type="hidden" name="content" id="content" value="{{ old('content', $article->content) }}">
                <div class="hint">Supports HTML formatting. Use the toolbar to format your content.</div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="category">Category *</label>
                    <select id="category" name="category" required>
                        <option value="">Select category</option>
                        @foreach (['analysis', 'consensus', 'trends', 'picks', 'news', 'general'] as $cat)
                            <option value="{{ $cat }}" {{ old('category', $article->category) === $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="sport">Sport</label>
                    <select id="sport" name="sport">
                        <option value="">All Sports</option>
                        @foreach (['NFL', 'NCAAF', 'NBA', 'NCAAB', 'NHL', 'MLB'] as $s)
                            <option value="{{ $s }}" {{ old('sport', $article->sport) === $s ? 'selected' : '' }}>
                                {{ $s }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="author">Author</label>
                    <input type="text" id="author" name="author" value="{{ old('author', $article->author) }}" placeholder="Author name">
                </div>
                <div class="form-group">
                    <label for="expert_name">Expert / Handicapper</label>
                    <input type="text" id="expert_name" name="expert_name" value="{{ old('expert_name', $article->expert_name) }}" placeholder="e.g., Sam Profeta">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="featured_image">Featured Image</label>
                    <input type="file" id="featured_image" name="featured_image" accept="image/*">
                    @if($article->featured_image)
                        <div style="margin-top:8px;">
                            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Current featured image" style="max-width:200px;max-height:150px;border-radius:8px;">
                            <div class="hint">Current image. Upload new to replace.</div>
                        </div>
                    @endif
                    <div class="hint">JPEG, PNG, JPG, GIF. Max 2MB.</div>
                </div>
                <div class="form-group"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:8px;">
                        <input type="checkbox" name="is_premium" value="1" {{ old('is_premium', $article->is_premium) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#4f46e5;">
                        <span>Premium Content</span>
                    </label>
                    <div class="hint">Only visible to subscribed members</div>
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:8px;">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#4f46e5;">
                        <span>Published</span>
                    </label>
                    <div class="hint">Uncheck to save as draft</div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                    {{ $article->exists ? 'Update Article' : 'Create Article' }}
                </button>
                <a href="{{ route('admin.articles.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- Quill Rich Text Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Quill
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image', 'video'],
                    ['clean']
                ]
            },
            placeholder: 'Write your article content here...'
        });
        
        // Sync Quill content with hidden textarea
        var contentInput = document.querySelector('input[name="content"]') || document.querySelector('textarea[name="content"]');
        if (contentInput) {
            // Set initial content
            if (contentInput.value) {
                quill.root.innerHTML = contentInput.value;
            }
            
            // Update hidden input on text change
            quill.on('text-change', function() {
                contentInput.value = quill.root.innerHTML;
            });
            
            // Also update on form submit
            var form = contentInput.closest('form');
            if (form) {
                form.addEventListener('submit', function() {
                    contentInput.value = quill.root.innerHTML;
                });
            }
        }
    });
</script>
@endsection
