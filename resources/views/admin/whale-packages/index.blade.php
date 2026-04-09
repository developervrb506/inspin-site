@extends('admin.layouts.admin')

@section('title', 'Whale Packages - INSPIN Admin')
@section('page-title', 'Whale Packages')
@section('breadcrumb')
    <span>Whale Packages</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Whale Packages</h2>
        <a href="{{ route('admin.whale-packages.create') }}" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M12 4v16m8-8H4"/></svg>
            New Whale Package
        </a>
    </div>
    <div class="card-body">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th style="width:160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($packages as $pkg)
                    <tr>
                        <td style="color:#94a3b8;">{{ $pkg->id }}</td>
                        <td style="font-weight:600;">{{ $pkg->title }}</td>
                        <td>${{ number_format($pkg->price, 2) }}</td>
                        <td>{{ $pkg->duration }}</td>
                        <td>
                            @if($pkg->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-neutral">Inactive</span>
                            @endif
                        </td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.whale-packages.edit', $pkg) }}" class="btn btn-ghost btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.whale-packages.destroy', $pkg) }}" style="display:inline;" onsubmit="return confirm('Delete this whale package?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6"><div class="empty-state"><h3>No whale packages yet</h3><p>Create your first whale package.</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
