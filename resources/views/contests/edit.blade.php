@extends('admin.layouts.admin')

@section('title', 'Edit Contest - INSPIN Admin')
@section('page-title', 'Edit Contest')
@section('breadcrumb')
    <a href="{{ route('contests.index') }}">Contests</a>
    <span class="sep">/</span>
    <a href="{{ route('contests.show', $contest) }}">#{{ $contest->id }}</a>
    <span class="sep">/</span>
    <span>Edit</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Contest #{{ $contest->id }}</h2>
        <a href="{{ route('contests.show', $contest) }}" class="btn btn-ghost">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            View Contest
        </a>
    </div>
    <form method="POST" action="{{ route('contests.update', $contest) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="name">Contest Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $contest->name) }}" required>
            </div>

            <div class="form-group">
                <label for="contest_type">Contest Type</label>
                <select id="contest_type" name="contest_type" required>
                    @foreach (['prediction', 'quiz', 'bracket', 'leaderboard'] as $type)
                        <option value="{{ $type }}" {{ old('contest_type', $contest->contest_type) === $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required>{{ old('description', $contest->description) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="starts_at">Start Date</label>
                    <input type="date" id="starts_at" name="starts_at" value="{{ old('starts_at', $contest->starts_at?->format('Y-m-d')) }}" required>
                </div>

                <div class="form-group">
                    <label for="ends_at">End Date</label>
                    <input type="date" id="ends_at" name="ends_at" value="{{ old('ends_at', $contest->ends_at?->format('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    @foreach (['draft', 'active', 'paused', 'inactive', 'completed'] as $status)
                        <option value="{{ $status }}" {{ old('status', $contest->status) === $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-footer">
            <div class="form-actions" style="margin-top:0;padding-top:0;border-top:none;">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                    Update Contest
                </button>
                <a href="{{ route('contests.show', $contest) }}" class="btn btn-ghost">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
