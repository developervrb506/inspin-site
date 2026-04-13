@extends('admin.layouts.admin')
@section('title', ($article->exists ? 'Edit Article' : 'New Article') . ' - INSPIN Admin')
@section('page-title', $article->exists ? 'Edit Article' : 'New Article')

@section('content')
<div style="max-width:900px;">
    <form method="POST"
          action="{{ $article->exists ? route('admin.articles.update', $article) : route('admin.articles.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if($article->exists) @method('PUT') @endif

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h2>Article Info</h2></div>
            <div class="card-body">
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Title <span class="required">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $article->title) }}" placeholder="Article title">
                    @error('title')<div class="form-error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grid-2" style="margin-bottom:16px;">
                    <div class="form-group">
                        <label>Category <span class="required">*</span></label>
                        <input type="text" name="category" class="form-control" value="{{ old('category', $article->category) }}" placeholder="e.g. Analysis, News, Tips">
                        @error('category')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Sport</label>
                        <select name="sport" class="form-control">
                            <option value="">— All Sports —</option>
                            @foreach(['NFL','NCAAF','NBA','NCAAB','MLB','NHL'] as $s)
                                <option value="{{ $s }}" {{ old('sport', $article->sport) === $s ? 'selected' : '' }}>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" name="author" class="form-control" value="{{ old('author', $article->author) }}" placeholder="Author name">
                    </div>
                    <div class="form-group">
                        <label>Expert Name</label>
                        <input type="text" name="expert_name" class="form-control" value="{{ old('expert_name', $article->expert_name) }}" placeholder="Expert display name">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:16px;">
                    <label>Excerpt</label>
                    <textarea name="excerpt" class="form-control" rows="2" placeholder="Short summary shown in article cards…">{{ old('excerpt', $article->excerpt) }}</textarea>
                </div>
                <div class="form-group">
                    <label>Content <span class="required">*</span></label>
                    <textarea name="content" class="form-control" rows="14" placeholder="Full article content…">{{ old('content', $article->content) }}</textarea>
                    @error('content')<div class="form-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="card" style="margin-bottom:20px;">
            <div class="card-header"><h2>Featured Image & Publishing</h2></div>
            <div class="card-body">
                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Featured Image</label>
                        <input type="file" name="featured_image" class="form-control" accept="image/*" onchange="previewImg(this,'featuredPreview')">
                        @if($article->featured_image)
                            <img id="featuredPreview" src="{{ asset('storage/'.$article->featured_image) }}" style="margin-top:8px;max-width:200px;border-radius:8px;border:1px solid #e2e8f0;">
                        @else
                            <img id="featuredPreview" src="" style="margin-top:8px;max-width:200px;border-radius:8px;border:1px solid #e2e8f0;display:none;">
                        @endif
                        @error('featured_image')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <div class="form-group" style="margin-bottom:12px;">
                            <label>Published At</label>
                            <input type="datetime-local" name="published_at" class="form-control"
                                   value="{{ old('published_at', $article->published_at?->format('Y-m-d\TH:i')) }}">
                        </div>
                        <div style="display:flex;flex-direction:column;gap:12px;margin-top:8px;">
                            <label class="form-check">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }}>
                                Published (visible on site)
                            </label>
                            <label class="form-check">
                                <input type="checkbox" name="is_premium" value="1" {{ old('is_premium', $article->is_premium) ? 'checked' : '' }}>
                                Premium (members only)
                            </label>
                        </div>
                    </div>
                </div>
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
@endsection

@push('scripts')
<script>
function previewImg(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
