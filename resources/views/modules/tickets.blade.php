@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Support Tickets</h1>
        @if (session('status'))
            <p>{{ session('status') }}</p>
        @endif
        <form method="GET" action="{{ route('modules.tickets') }}">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search subject or email">
            <button type="submit">Search</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->subject }}</td>
                        <td>{{ $ticket->customer_email }}</td>
                        <td>
                            <form method="POST" action="{{ route('modules.tickets.status', $ticket) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="q" value="{{ $search }}">
                                <input type="hidden" name="page" value="{{ $tickets->currentPage() }}">
                                <select name="status">
                                    @foreach (['open', 'pending', 'resolved', 'closed'] as $status)
                                        <option value="{{ $status }}" {{ $ticket->status === $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No tickets imported yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $tickets->links() }}
    </div>
@endsection
