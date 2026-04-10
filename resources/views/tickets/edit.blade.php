@extends('admin.layouts.admin')

@section('title', 'Edit Ticket - INSPIN Admin')
@section('page-title', 'Edit Ticket')
@section('breadcrumb')
    <a href="{{ route('tickets.index') }}">Tickets</a>
    <span class="sep">/</span>
    <a href="{{ route('tickets.show', $ticket) }}">#{{ $ticket->id }}</a>
    <span class="sep">/</span>
    <span>Edit</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Ticket #{{ $ticket->id }}</h2>
        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-ghost">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            View Ticket
        </a>
    </div>
    <form method="POST" action="{{ route('tickets.update', $ticket) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $ticket->customer_name) }}" required>
            </div>

            <div class="form-group">
                <label for="customer_email">Customer Email</label>
                <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email', $ticket->customer_email) }}" required>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" value="{{ old('subject', $ticket->subject) }}" required>
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required>{{ old('message', $ticket->message) }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        @foreach (['open', 'pending', 'resolved', 'closed'] as $status)
                            <option value="{{ $status }}" {{ old('status', $ticket->status) === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="priority">Priority (1-5)</label>
                    <input type="number" id="priority" name="priority" min="1" max="5" value="{{ old('priority', $ticket->priority) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="source_system">Source System</label>
                    <input type="text" id="source_system" name="source_system" value="{{ old('source_system', $ticket->source_system) }}">
                </div>

                <div class="form-group">
                    <label for="external_id">External ID</label>
                    <input type="text" id="external_id" name="external_id" value="{{ old('external_id', $ticket->external_id) }}">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="form-actions" style="margin-top:0;padding-top:0;border-top:none;">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                    Update Ticket
                </button>
                <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-ghost">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
