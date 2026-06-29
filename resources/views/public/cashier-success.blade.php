@extends('layouts.public')
@section('title', 'Order Confirmed - INSPIN')

@section('content')
<div style="max-width:560px;margin:0 auto;padding:80px 24px;text-align:center;">
    <div style="width:64px;height:64px;border-radius:50%;background:rgba(0,209,91,.1);border:1px solid rgba(0,209,91,.3);display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 24px;">✓</div>

    <h1 style="font-family:'Clash Display',sans-serif;font-size:1.8rem;font-weight:600;color:#FFFCEE;margin-bottom:10px;">Payment Successful</h1>
    <p style="color:#9a9a9a;font-size:14.5px;margin-bottom:32px;">Your package is active. A confirmation email is on its way to {{ $userPackage->user->email }}.</p>

    <div style="background:#1e1e1e;border:1px solid rgba(255,252,238,.07);border-radius:14px;padding:24px;text-align:left;margin-bottom:32px;">
        <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid rgba(255,252,238,.06);">
            <span style="color:#6e6e6e;font-size:13px;">Package</span>
            <span style="color:#FFFCEE;font-size:13.5px;font-weight:600;">{{ $userPackage->package->name }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid rgba(255,252,238,.06);">
            <span style="color:#6e6e6e;font-size:13px;">Amount Charged</span>
            <span style="color:#FDB515;font-size:13.5px;font-weight:700;">${{ number_format($userPackage->amount_paid, 2) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid rgba(255,252,238,.06);">
            <span style="color:#6e6e6e;font-size:13px;">Access Starts</span>
            <span style="color:#FFFCEE;font-size:13.5px;font-weight:600;">{{ $userPackage->starts_at->format('M j, Y') }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;padding:8px 0;">
            <span style="color:#6e6e6e;font-size:13px;">Access Expires</span>
            <span style="color:#FFFCEE;font-size:13.5px;font-weight:600;">{{ $userPackage->expires_at->format('M j, Y') }}</span>
        </div>
    </div>

    <a href="/subscriber/dashboard" style="display:inline-block;padding:13px 36px;background:#FDB515;color:#171818;border-radius:50px;font-weight:700;font-size:14px;text-decoration:none;">Go to Dashboard</a>
</div>
@endsection
