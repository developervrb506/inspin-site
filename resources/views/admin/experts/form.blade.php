@extends('admin.layouts.admin')

@section('title', ($expert->exists ? 'Edit' : 'Create') . ' Expert - INSPIN Admin')
@section('page-title', $expert->exists ? 'Edit Expert' : 'Create Expert')
@section('breadcrumb')
    <a href="{{ route('admin.experts.index') }}">Experts</a>
    <span class="sep">/</span>
    <span>{{ $expert->exists ? 'Edit' : 'Create' }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>{{ $expert->exists ? 'Edit Expert' : 'Create New Expert' }}</h2>
        <a href="{{ route('admin.experts.index') }}" class="btn btn-ghost">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Experts
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $expert->exists ? route('admin.experts.update', $expert) : route('admin.experts.store') }}" enctype="multipart/form-data">
            @csrf
            @if($expert->exists) @method('PUT') @endif

            <div class="form-group">
                <label for="name">Expert Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $expert->name) }}" placeholder="e.g., John Smith" required>
                <div class="hint">This will be displayed on picks and articles</div>
            </div>

            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="4" placeholder="Brief description of the expert's background and specialty...">{{ old('bio', $expert->bio) }}</textarea>
                <div class="hint">Optional background information</div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="avatar">Profile Photo</label>
                    <input type="file" id="avatar" name="avatar" accept="image/*">
                    @if($expert->avatar)
                        <div style="margin-top:8px;">
                            <img src="{{ $expert->avatar_url }}" alt="Current avatar" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
                            <div class="hint">Current photo. Upload new to replace.</div>
                        </div>
                    @endif
                    <div class="hint">JPEG, PNG, JPG, GIF. Max 2MB.</div>
                </div>
                <div class="form-group"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="specialty">Specialty</label>
                    <select id="specialty" name="specialty">
                        <option value="">All Sports</option>
                        @foreach (['NFL', 'NCAAF', 'NBA', 'NCAAB', 'NHL', 'MLB'] as $sport)
                            <option value="{{ $sport }}" {{ old('specialty', $expert->specialty) === $sport ? 'selected' : '' }}>
                                {{ $sport }}
                            </option>
                        @endforeach
                    </select>
                    <div class="hint">Primary sport specialization</div>
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:8px;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $expert->is_active) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#4f46e5;">
                        <span>Active</span>
                    </label>
                    <div class="hint">Only active experts appear in dropdowns</div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                    {{ $expert->exists ? 'Update Expert' : 'Create Expert' }}
                </button>
                <a href="{{ route('admin.experts.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection