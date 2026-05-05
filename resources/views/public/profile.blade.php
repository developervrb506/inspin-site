@extends('layouts.subscriber')
@section('title', 'My Profile - INSPIN')
@section('page-title', 'My Profile')

@section('content')
@php $user = auth()->user(); $sub = $user->activeSubscription()?->load('package'); @endphp

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">
    {{-- Account Details --}}
    <div class="stat-card">
        <div class="stat-label">Account Details</div>
        <div style="margin-top:8px;display:flex;flex-direction:column;gap:10px;">
            <div style="display:flex;justify-content:space-between;padding-bottom:10px;border-bottom:1px solid rgba(255,252,238,.06);">
                <span style="font-size:13px;color:#6e6e6e;">Name</span>
                <span style="font-size:13px;font-weight:600;color:#FFFCEE;">{{ $user->name }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding-bottom:10px;border-bottom:1px solid rgba(255,252,238,.06);">
                <span style="font-size:13px;color:#6e6e6e;">Email</span>
                <span style="font-size:13px;color:#FFFCEE;">{{ $user->email }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding-bottom:10px;border-bottom:1px solid rgba(255,252,238,.06);">
                <span style="font-size:13px;color:#6e6e6e;">Phone</span>
                <span style="font-size:13px;color:#FFFCEE;">{{ $user->phone ?? 'Not set' }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="font-size:13px;color:#6e6e6e;">Member since</span>
                <span style="font-size:13px;color:#FFFCEE;">{{ $user->created_at->format('M d, Y') }}</span>
            </div>
        </div>
        <div style="margin-top:16px;">
            <a href="{{ route('account.settings') }}" style="display:inline-block;padding:9px 20px;border:1px solid rgba(255,252,238,.15);color:#FFFCEE;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;transition:border-color .15s;" onmouseover="this.style.borderColor='#FDB515'" onmouseout="this.style.borderColor='rgba(255,252,238,.15)'">Edit Settings →</a>
        </div>
    </div>

    {{-- Membership --}}
    <div class="stat-card" style="border-color:rgba(253,181,21,.12);">
        <div class="stat-label">Active Package</div>
        @if($sub)
        <div style="margin-top:8px;">
            <div style="font-family:'Clash Display',sans-serif;font-size:1.2rem;font-weight:500;color:#FFFCEE;margin-bottom:4px;">{{ $sub->packageName() }}</div>
            <div style="font-size:14px;color:#FDB515;margin-bottom:12px;">{{ str_repeat('★', $sub->max_stars > 5 ? 5 : $sub->max_stars) }}{{ $sub->max_stars > 5 ? '+' : '' }} Access</div>
            <div style="font-size:12px;color:#6e6e6e;margin-bottom:16px;">
                @if($sub->isExpired() && $sub->status_note !== 'extended')
                    <span style="color:#ef4444;">✗ Expired</span>
                @elseif($sub->status_note === 'extended')
                    <span style="color:#6366f1;">⟳ Extended (unit-based)</span>
                @else
                    Expires <strong style="color:#FFFCEE;">{{ $sub->expires_at->format('M d, Y') }}</strong> · {{ $sub->daysRemaining() }} days left
                @endif
            </div>
            @if($sub->max_stars < 10)
            <a href="{{ route('join') }}" style="display:inline-block;padding:9px 20px;background:#FDB515;color:#171818;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;">Upgrade Package →</a>
            @endif
        </div>
        @else
        <div style="margin-top:8px;">
            <p style="font-size:13px;color:#6e6e6e;margin-bottom:16px;">You don't have an active package. Subscribe to access expert picks.</p>
            <a href="{{ route('join') }}" style="display:inline-block;padding:9px 20px;background:#FDB515;color:#171818;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;">View Packages →</a>
        </div>
        @endif
    </div>
</div>

@if($tickets->count() > 0)
<div class="stat-card" style="margin-top:4px;">
    <div class="stat-label" style="margin-bottom:12px;">My Support Tickets</div>
    <table style="width:100%;border-collapse:collapse;">
        <thead>
            <tr style="border-bottom:1px solid rgba(255,252,238,.08);">
                <th style="padding:8px 0;font-size:11px;color:#6e6e6e;text-align:left;font-weight:700;text-transform:uppercase;letter-spacing:.4px;">ID</th>
                <th style="padding:8px 0;font-size:11px;color:#6e6e6e;text-align:left;font-weight:700;text-transform:uppercase;letter-spacing:.4px;">Subject</th>
                <th style="padding:8px 0;font-size:11px;color:#6e6e6e;text-align:left;font-weight:700;text-transform:uppercase;letter-spacing:.4px;">Status</th>
                <th style="padding:8px 0;font-size:11px;color:#6e6e6e;text-align:left;font-weight:700;text-transform:uppercase;letter-spacing:.4px;">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
            <tr style="border-bottom:1px solid rgba(255,252,238,.04);">
                <td style="padding:10px 0;font-size:13px;color:#6e6e6e;">#{{ $ticket->id }}</td>
                <td style="padding:10px 0;font-size:13px;color:#FFFCEE;">{{ Str::limit($ticket->subject, 40) }}</td>
                <td style="padding:10px 0;"><span style="font-size:11px;font-weight:700;padding:3px 8px;border-radius:6px;background:rgba(0,209,91,.1);color:#00D15B;">{{ ucfirst($ticket->status) }}</span></td>
                <td style="padding:10px 0;font-size:12px;color:#6e6e6e;">{{ $ticket->created_at->format('M d, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection
