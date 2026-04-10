@extends('admin.layouts.admin')

@section('title', 'Create Ticket - INSPIN Admin')
@section('page-title', 'Create Support Ticket')
@section('breadcrumb')
    <a href="{{ route('tickets.index') }}">Tickets</a>
    <span class="sep">/</span>
    <span>Create</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>New Support Ticket</h2>
        <a href="{{ route('tickets.index') }}" class="btn btn-ghost">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Tickets
        </a>
    </div>
    <form method="POST" action="{{ route('tickets.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="customer_name">Customer Name</label>
                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
            </div>

            <div class="form-group">
                <label for="customer_email">Customer Email</label>
                <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required>
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" required>
                        @foreach (['open', 'pending', 'resolved', 'closed'] as $status)
                            <option value="{{ $status }}" {{ old('status', 'open') === $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="priority">Priority (1-5)</label>
                    <input type="number" id="priority" name="priority" min="1" max="5" value="{{ old('priority', 3) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="source_system">Source System</label>
                    <input type="text" id="source_system" name="source_system" value="{{ old('source_system', 'legacy') }}">
                </div>

                <div class="form-group">
                    <label for="external_id">External ID</label>
                    <input type="text" id="external_id" name="external_id" value="{{ old('external_id') }}">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="form-actions" style="margin-top:0;padding-top:0;border-top:none;">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                    Create Ticket
                </button>
                <a href="{{ route('tickets.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
