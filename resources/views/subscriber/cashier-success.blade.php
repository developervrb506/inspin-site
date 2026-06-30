@extends('layouts.subscriber')
@section('title', 'Order Confirmed - INSPIN')
@section('page-title', 'Order Confirmed')

@section('content')
<div style="max-width:520px;margin:0 auto;padding:12px 0 48px;text-align:center;">

    {{-- Success icon --}}
    <div style="width:76px;height:76px;border-radius:50%;background:rgba(0,209,91,.07);border:1.5px solid rgba(0,209,91,.2);display:inline-flex;align-items:center;justify-content:center;margin-bottom:24px;">
        <svg width="32" height="32" fill="none" viewBox="0 0 24 24"><path stroke="#00D15B" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg>
    </div>

    <h1 style="font-family:'Clash Display',sans-serif;font-size:2rem;font-weight:700;color:#FFFCEE;margin-bottom:10px;letter-spacing:-.3px;">Payment Successful</h1>
    <p style="color:#6e6e6e;font-size:14px;line-height:1.7;margin-bottom:32px;">
        Your package is now active.<br>
        A confirmation email is on its way to<br>
        <span style="color:#FFFCEE;font-weight:600;">{{ $userPackage->user->email }}</span>
    </p>

    {{-- Order card --}}
    <div style="background:#1a1a1a;border:1px solid rgba(255,252,238,.07);border-radius:16px;padding:8px 24px 16px;text-align:left;margin-bottom:28px;">
        <div style="font-size:10px;color:#6e6e6e;text-transform:uppercase;letter-spacing:.6px;font-weight:600;padding:16px 0 12px;border-bottom:1px solid rgba(255,252,238,.05);">Order Summary</div>

        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid rgba(255,252,238,.05);">
            <span style="color:#6e6e6e;font-size:13px;">Package</span>
            <span style="color:#FFFCEE;font-size:13.5px;font-weight:600;">{{ $userPackage->package->name }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid rgba(255,252,238,.05);">
            <span style="color:#6e6e6e;font-size:13px;">Amount Charged</span>
            <span style="color:#FDB515;font-size:15px;font-weight:700;">${{ number_format($userPackage->amount_paid, 2) }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:1px solid rgba(255,252,238,.05);">
            <span style="color:#6e6e6e;font-size:13px;">Access Starts</span>
            <span style="color:#FFFCEE;font-size:13.5px;font-weight:600;">{{ $userPackage->starts_at->format('M j, Y') }}</span>
        </div>
        <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;">
            <span style="color:#6e6e6e;font-size:13px;">Access Expires</span>
            <span style="color:#FFFCEE;font-size:13.5px;font-weight:600;">{{ $userPackage->expires_at->format('M j, Y') }}</span>
        </div>
    </div>

    {{-- CTA --}}
    <a href="/subscriber/dashboard" style="display:inline-flex;align-items:center;gap:9px;padding:15px 42px;background:#FDB515;color:#171818;border-radius:50px;font-weight:700;font-size:14.5px;text-decoration:none;letter-spacing:.1px;">
        Go to Dashboard
        <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path stroke="#171818" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>

    <p style="margin-top:22px;font-size:12px;color:#444;line-height:1.6;">
        Questions? Reach us at <a href="mailto:help@inspin.com" style="color:#FDB515;text-decoration:none;">help@inspin.com</a>
        or call <a href="tel:+16108704799" style="color:#FDB515;text-decoration:none;">610-870-4799</a>
    </p>
</div>
@endsection
