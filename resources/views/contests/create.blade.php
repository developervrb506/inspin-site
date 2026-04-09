@extends('admin.layouts.admin')

@section('title', 'Create Contest - INSPIN Admin')
@section('page-title', 'Create Contest')
@section('breadcrumb')
    <a href="{{ route('contests.index') }}">Contests</a>
    <span class="sep">/</span>
    <span>Create</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>New Contest</h2>
        <a href="{{ route('contests.index') }}" class="btn btn-ghost">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Contests
        </a>
    </div>
    <form method="POST" action="{{ route('contests.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Contest Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="contest_type">Contest Type</label>
                <select id="contest_type" name="contest_type" required>
                    @foreach (['prediction', 'quiz', 'bracket', 'leaderboard'] as $type)
                        <option value="{{ $type }}" {{ old('contest_type') === $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="starts_at">Start Date</label>
                    <input type="date" id="starts_at" name="starts_at" value="{{ old('starts_at') }}" required>
                </div>

                <div class="form-group">
                    <label for="ends_at">End Date</label>
                    <input type="date" id="ends_at" name="ends_at" value="{{ old('ends_at') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    @foreach (['draft', 'active', 'paused', 'inactive', 'completed'] as $status)
                        <option value="{{ $status }}" {{ old('status', 'draft') === $status ? 'selected' : '' }}>
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
                    Create Contest
                </button>
                <a href="{{ route('contests.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
