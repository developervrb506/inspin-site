@extends('admin.layouts.admin')

@section('title', 'Support Tickets - INSPIN Admin')
@section('page-title', 'Support Tickets')
@section('breadcrumb')
    <span>Tickets</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>All Tickets</h2>
        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
            New Ticket
        </a>
    </div>

    <div class="card-body">
        <form method="GET" action="{{ route('tickets.index') }}" class="search-bar">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search subject, name, or email">
            <select name="status" style="padding:10px 16px;border:1.5px solid var(--border);border-radius:8px;font-size:14px;min-width:160px;">
                <option value="">All Statuses</option>
                @foreach (['open', 'pending', 'resolved', 'closed'] as $status)
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
                <a href="{{ route('tickets.index') }}" class="btn btn-ghost">Clear</a>
            @endif
        </form>
    </div>

    <div class="table-wrap">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ Str::limit($ticket->subject, 40) }}</td>
                        <td>{{ $ticket->customer_name }}</td>
                        <td>{{ $ticket->customer_email }}</td>
                        <td>
                            <span class="badge badge-{{ $ticket->status === 'open' ? 'info' : ($ticket->status === 'pending' ? 'warning' : ($ticket->status === 'resolved' ? 'success' : 'neutral')) }}">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </td>
                        <td>{{ $ticket->priority }}/5</td>
                        <td>{{ $ticket->created_at?->format('Y-m-d') ?? 'N/A' }}</td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-ghost btn-sm">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                View
                            </a>
                            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-ghost btn-sm">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" style="display:inline;" onsubmit="return confirm('Delete this ticket?');">
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
                        <td colspan="8">
                            <div class="empty-state">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                <h3>No tickets found</h3>
                                <p>Get started by creating a new support ticket.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($tickets->hasPages())
        <div class="card-footer">
            {{ $tickets->links() }}
        </div>
    @endif
</div>
@endsection
