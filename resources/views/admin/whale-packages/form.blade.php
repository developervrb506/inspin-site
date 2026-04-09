@extends('admin.layouts.admin')

@section('title', ($package->exists ? 'Edit' : 'Create') . ' Whale Package - INSPIN Admin')
@section('page-title', $package->exists ? 'Edit Whale Package' : 'Create Whale Package')
@section('breadcrumb')
    <a href="{{ route('admin.whale-packages.index') }}">Whale Packages</a>
    <span class="sep">/</span>
    <span>{{ $package->exists ? 'Edit' : 'Create' }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>{{ $package->exists ? 'Edit Whale Package' : 'Create Whale Package' }}</h2>
        <a href="{{ route('admin.whale-packages.index') }}" class="btn btn-ghost">Back</a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $package->exists ? route('admin.whale-packages.update', $package) : route('admin.whale-packages.store') }}">
            @csrf
            @if($package->exists) @method('PUT') @endif

            <div class="form-group">
                <label for="title">Package Title *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $package->title) }}" placeholder="e.g., NFL Whale Package" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" placeholder="Package description...">{{ old('description', $package->description) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price ($) *</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price', $package->price) }}" required>
                </div>
                <div class="form-group">
                    <label for="duration">Duration Label</label>
                    <input type="text" id="duration" name="duration" value="{{ old('duration', $package->duration) }}" placeholder="e.g., Season">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="duration_days">Duration (Days)</label>
                    <input type="number" id="duration_days" name="duration_days" value="{{ old('duration_days', $package->duration_days) }}" placeholder="30">
                </div>
                <div class="form-group">
                    <label for="sort_order">Sort Order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $package->sort_order) }}" placeholder="0">
                </div>
            </div>

            <div class="form-group">
                <label for="features">Features (one per line)</label>
                <textarea id="features" name="features" rows="5" placeholder="All NFL Picks&#10;Exclusive Analysis&#10;Priority Support">{{ is_array($package->features) ? implode("\n", $package->features) : old('features', '') }}</textarea>
            </div>

            <div class="form-group">
                <label style="display:flex;align-items:center;gap:8px;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#4f46e5;">
                    Active (show on homepage)
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                    {{ $package->exists ? 'Update' : 'Create' }}
                </button>
                <a href="{{ route('admin.whale-packages.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
