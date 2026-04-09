@extends('admin.layouts.admin')

@section('title', 'Contests - INSPIN Admin')
@section('page-title', 'Contests')
@section('breadcrumb')
    <span>Contests</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>All Contests</h2>
        <a href="{{ route('contests.create') }}" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
            New Contest
        </a>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('contests.index') }}" class="search-bar">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search name, type, or description">
            <select name="status" style="padding:10px 16px;border:1.5px solid var(--border);border-radius:8px;font-size:14px;min-width:160px;">
                <option value="">All Statuses</option>
                @foreach (['draft', 'active', 'paused', 'inactive', 'completed'] as $status)
                    <option value="{{ $status }}" {{ $statusFilter === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-ghost">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                Search
            </button>
            @if($search || $statusFilter)
                <a href="{{ route('contests.index') }}" class="btn btn-ghost">Clear</a>
            @endif
        </form>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Starts</th>
                    <th>Ends</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contests as $contest)
                    <tr>
                        <td>{{ $contest->id }}</td>
                        <td>{{ Str::limit($contest->name, 40) }}</td>
                        <td>{{ ucfirst($contest->contest_type) }}</td>
                        <td>
                            <span class="badge badge-{{ $contest->status === 'active' ? 'success' : ($contest->status === 'draft' ? 'neutral' : ($contest->status === 'paused' ? 'warning' : ($contest->status === 'completed' ? 'info' : 'neutral'))) }}">
                                {{ ucfirst($contest->status) }}
                            </span>
                        </td>
                        <td>{{ $contest->starts_at?->format('Y-m-d') ?? 'N/A' }}</td>
                        <td>{{ $contest->ends_at?->format('Y-m-d') ?? 'N/A' }}</td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('contests.show', $contest) }}" class="btn btn-ghost btn-sm">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                View
                            </a>
                            <a href="{{ route('contests.edit', $contest) }}" class="btn btn-ghost btn-sm">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('contests.destroy', $contest) }}" style="display:inline;" onsubmit="return confirm('Delete this contest?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                <h3>No contests found</h3>
                                <p>Get started by creating a new contest.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($contests->hasPages())
        <div class="card-footer">
            {{ $contests->links() }}
        </div>
    @endif
</div>
@endsection
