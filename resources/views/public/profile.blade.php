@extends('layouts.public')
@section('title', 'My Profile - INSPIN')

@section('content')
<div class="section">
    <div class="container">
        <h1 class="section-title">My Profile</h1>
        <p class="section-sub">Welcome, {{ auth()->user()->name }}</p>

        <div class="grid grid-2">
            <div class="card">
                <div class="card-body">
                    <h3>Account Details</h3>
                    <p style="margin-top:12px;"><strong style="color:#0f172a;">Name:</strong> {{ auth()->user()->name }}</p>
                    <p><strong style="color:#0f172a;">Email:</strong> {{ auth()->user()->email }}</p>
                    <p><strong style="color:#0f172a;">Role:</strong> {{ ucfirst(auth()->user()->role ?? 'Free') }}</p>
                    <p><strong style="color:#0f172a;">Phone:</strong> {{ auth()->user()->phone ?? 'Not set' }}</p>
                    <a href="{{ route('account.settings') }}" class="btn btn-outline" style="margin-top:12px;">Edit Settings</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Membership</h3>
                    <p style="margin-top:12px;">Upgrade your account to access all INSPIN simulation picks and analysis.</p>
                    <a href="{{ route('join') }}" class="btn btn-red" style="margin-top:12px;">View Packages</a>
                </div>
            </div>
        </div>

        @if($tickets->count() > 0)
        <div style="margin-top:24px;">
            <h2 class="section-title">My Support Tickets</h2>
            <table class="c-table" style="margin-top:12px;">
                <thead><tr><th>ID</th><th>Subject</th><th>Status</th><th>Date</th></tr></thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    <tr>
                        <td>#{{ $ticket->id }}</td>
                        <td>{{ Str::limit($ticket->subject, 50) }}</td>
                        <td><span class="badge badge-{{ $ticket->status }}">{{ ucfirst($ticket->status) }}</span></td>
                        <td>{{ $ticket->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
