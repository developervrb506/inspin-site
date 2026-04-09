@extends('admin.layouts.admin')

@section('title', 'Users - INSPIN Admin')
@section('page-title', 'Users')
@section('breadcrumb')
    <span>Users</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>All Users</h2>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.users.index') }}" class="search-bar">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search users by name or email...">
            <button type="submit" class="btn btn-primary">Search</button>
            @if($search)<a href="{{ route('admin.users.index') }}" class="btn btn-ghost">Clear</a>@endif
        </form>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th style="width:160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr>
                        <td style="color:#94a3b8;">{{ $user->id }}</td>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div style="width:32px;height:32px;border-radius:50%;background:#4f46e5;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:12px;flex-shrink:0;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div style="font-weight:600;">{{ $user->name }}</div>
                            </div>
                        </td>
                        <td style="color:#64748b;">{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge badge-danger">Admin</span>
                            @elseif($user->role === 'vip')
                                <span class="badge badge-warning">VIP</span>
                            @elseif($user->role === 'member')
                                <span class="badge badge-info">Member</span>
                            @else
                                <span class="badge badge-neutral">Free</span>
                            @endif
                        </td>
                        <td style="color:#64748b;">{{ $user->phone ?? '-' }}</td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-ghost btn-sm">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline;" onsubmit="return confirm('Delete this user?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Delete
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                <h3>No users found</h3>
                                <p>Users will appear here when they register.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($users->hasPages())
    <div class="card-footer">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
