@extends('admin.layouts.admin')

@section('title', 'Ticket #' . $ticket->id . ' - INSPIN Admin')
@section('page-title', 'Ticket #' . $ticket->id)
@section('breadcrumb')
    <a href="{{ route('tickets.index') }}">Tickets</a>
    <span class="sep">/</span>
    <span>#{{ $ticket->id }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Ticket #{{ $ticket->id }}</h2>
        <div style="display:flex;gap:8px;">
            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-primary">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            <a href="{{ route('tickets.index') }}" class="btn btn-ghost">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to List
            </a>
        </div>
    </div>

    <div class="card-body">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:20px;">
            <div>
                <div style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Customer Name</div>
                <div>{{ $ticket->customer_name }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Customer Email</div>
                <div>{{ $ticket->customer_email }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Subject</div>
                <div>{{ $ticket->subject }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Status</div>
                <span class="badge badge-{{ $ticket->status === 'open' ? 'info' : ($ticket->status === 'pending' ? 'warning' : ($ticket->status === 'resolved' ? 'success' : 'neutral')) }}">{{ ucfirst($ticket->status) }}</span>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Priority</div>
                <div>{{ $ticket->priority }}/5</div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Source System</div>
                <div>{{ $ticket->source_system ?? 'N/A' }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">External ID</div>
                <div>{{ $ticket->external_id ?? 'N/A' }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Created</div>
                <div>{{ $ticket->created_at?->format('Y-m-d H:i') ?? 'N/A' }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:4px;">Updated</div>
                <div>{{ $ticket->updated_at?->format('Y-m-d H:i') ?? 'N/A' }}</div>
            </div>
        </div>

        <div style="margin-top:24px;padding-top:20px;border-top:1px solid var(--border);">
            <div style="font-size:12px;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.5px;font-weight:700;margin-bottom:8px;">Message</div>
            <div style="white-space:pre-wrap;">{{ $ticket->message }}</div>
        </div>
    </div>

    <div class="card-footer">
        <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" onsubmit="return confirm('Are you sure you want to delete this ticket? This cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Delete Ticket
            </button>
        </form>
    </div>
</div>
@endsection
