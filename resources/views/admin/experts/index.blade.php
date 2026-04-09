@extends('admin.layouts.admin')

@section('title', 'Experts - INSPIN Admin')
@section('page-title', 'Experts')
@section('breadcrumb')
    <span>Experts</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>All Experts</h2>
        <a href="{{ route('admin.experts.create') }}" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M12 4v16m8-8H4"/></svg>
            New Expert
        </a>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.experts.index') }}" class="search-bar">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search experts by name or specialty...">
            <button type="submit" class="btn btn-primary">Search</button>
            @if($search)<a href="{{ route('admin.experts.index') }}" class="btn btn-ghost">Clear</a>@endif
        </form>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Expert</th>
                        <th>Specialty</th>
                        <th>Status</th>
                        <th style="width:160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($experts as $expert)
                    <tr>
                        <td style="color:#94a3b8;">{{ $expert->id }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <img src="{{ $expert->avatar_url }}" alt="{{ $expert->name }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;">
                                <div>
                                    <div style="font-weight:600;">{{ $expert->name }}</div>
                                    <div style="font-size:12px;color:#94a3b8;">{{ $expert->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-{{ strtolower($expert->specialty ?? 'neutral') }}">{{ $expert->specialty ?? 'General' }}</span></td>
                        <td>
                            @if($expert->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-neutral">Inactive</span>
                            @endif
                        </td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.experts.edit', $expert) }}" class="btn btn-ghost btn-sm">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.experts.destroy', $expert) }}" style="display:inline;" onsubmit="return confirm('Delete this expert?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div style="font-size:2rem;margin-bottom:8px;">👤</div>
                                <h3>No experts yet</h3>
                                <p>Create your first expert to get started.</p>
                                <a href="{{ route('admin.experts.create') }}" class="btn btn-primary">Create Expert</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $experts->links() }}
    </div>
</div>
@endsection