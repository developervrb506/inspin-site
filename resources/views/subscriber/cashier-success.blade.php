@extends('layouts.subscriber')
@section('title', 'Order Confirmed - INSPIN')
@section('page-title', 'Order Confirmed')

@push('styles')
<style>
    /* ── Keyframes ── */
    @keyframes ringPulse {
        0%   { transform: scale(.85); opacity: .7; }
        50%  { transform: scale(1.15); opacity: .3; }
        100% { transform: scale(.85); opacity: .7; }
    }
    @keyframes ringPulse2 {
        0%   { transform: scale(.9); opacity: .4; }
        50%  { transform: scale(1.3); opacity: .08; }
        100% { transform: scale(.9); opacity: .4; }
    }
    @keyframes circlePop {
        0%   { transform: scale(0); opacity: 0; }
        60%  { transform: scale(1.08); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @keyframes rowSlide {
        from { opacity: 0; transform: translateX(-10px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes shimmer {
        0%   { background-position: -200% center; }
        100% { background-position: 200% center; }
    }
    @keyframes btnBounce {
        0%,100% { transform: translateY(0); }
        40%     { transform: translateY(-4px); }
        60%     { transform: translateY(-2px); }
    }

    /* ── Page wrapper ── */
    .success-wrap {
        max-width: 540px;
        margin: 0 auto;
        padding: 20px 0 56px;
        text-align: center;
    }

    /* ── Icon area ── */
    .success-icon-area {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* outer pulse ring */
    .success-ring-2 {
        position: absolute; inset: -18px;
        border-radius: 50%;
        border: 1.5px solid rgba(0,209,91,.12);
        animation: ringPulse2 2.8s ease-in-out 1.2s infinite;
        opacity: 0;
        animation-fill-mode: both;
    }
    /* inner pulse ring */
    .success-ring-1 {
        position: absolute; inset: -8px;
        border-radius: 50%;
        border: 1.5px solid rgba(0,209,91,.22);
        animation: ringPulse 2.2s ease-in-out 1s infinite;
        opacity: 0;
        animation-fill-mode: both;
    }
    /* circle background */
    .success-circle {
        width: 100%; height: 100%;
        border-radius: 50%;
        background: radial-gradient(circle at 40% 35%, rgba(0,209,91,.18), rgba(0,209,91,.06));
        border: 1.5px solid rgba(0,209,91,.25);
        display: flex; align-items: center; justify-content: center;
        animation: circlePop .55s cubic-bezier(.34,1.4,.64,1) .1s both;
        position: relative;
        z-index: 1;
    }
    /* SVG checkmark — draws itself */
    .check-svg {
        width: 48px; height: 48px;
    }
    .check-path {
        stroke: #00D15B;
        stroke-width: 3.5;
        stroke-linecap: round;
        stroke-linejoin: round;
        fill: none;
        stroke-dasharray: 40;
        stroke-dashoffset: 40;
        animation: drawCheck .5s ease .65s forwards;
    }
    @keyframes drawCheck {
        to { stroke-dashoffset: 0; }
    }

    /* ── Heading ── */
    .success-title {
        font-family: 'Clash Display', sans-serif;
        font-size: 2.1rem;
        font-weight: 700;
        color: #FFFCEE;
        letter-spacing: -.3px;
        margin-bottom: 10px;
        animation: fadeUp .45s ease .75s both;
    }
    .success-sub {
        color: #555;
        font-size: 14px;
        line-height: 1.75;
        margin-bottom: 36px;
        animation: fadeUp .45s ease .85s both;
    }
    .success-sub strong {
        color: #FFFCEE;
        font-weight: 600;
        display: block;
        font-size: 14.5px;
    }

    /* ── Order card ── */
    .order-card {
        background: #191919;
        border: 1px solid rgba(255,252,238,.07);
        border-radius: 18px;
        overflow: hidden;
        margin-bottom: 28px;
        text-align: left;
        animation: fadeUp .45s ease .95s both;
    }
    .order-card-header {
        padding: 16px 22px 14px;
        border-bottom: 1px solid rgba(255,252,238,.06);
        display: flex; align-items: center; justify-content: space-between;
    }
    .order-card-label {
        font-size: 10px; color: #444; text-transform: uppercase;
        letter-spacing: .7px; font-weight: 700;
    }
    .order-card-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px;
        color: #00D15B; background: rgba(0,209,91,.07);
        border: 1px solid rgba(0,209,91,.2); border-radius: 20px; padding: 3px 10px;
    }
    .order-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 14px 22px;
        opacity: 0;
    }
    .order-row + .order-row { border-top: 1px solid rgba(255,252,238,.05); }
    .order-key { font-size: 13px; color: #555; }
    .order-val { font-size: 13.5px; color: #FFFCEE; font-weight: 600; }
    .order-val.gold { color: #FDB515; font-size: 16px; font-weight: 700; }

    /* stagger each row */
    .order-row:nth-child(1) { animation: rowSlide .35s ease 1.05s forwards; }
    .order-row:nth-child(2) { animation: rowSlide .35s ease 1.15s forwards; }
    .order-row:nth-child(3) { animation: rowSlide .35s ease 1.25s forwards; }
    .order-row:nth-child(4) { animation: rowSlide .35s ease 1.35s forwards; }

    /* ── CTA ── */
    .success-btn {
        display: inline-flex; align-items: center; gap: 9px;
        padding: 15px 44px;
        background: #FDB515;
        color: #171818;
        border-radius: 50px;
        font-weight: 700;
        font-size: 15px;
        text-decoration: none;
        letter-spacing: .1px;
        transition: background .15s, transform .2s, box-shadow .2s;
        animation: fadeUp .45s ease 1.4s both;
        position: relative;
        overflow: hidden;
    }
    .success-btn::after {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,.18) 50%, transparent 100%);
        background-size: 200% auto;
        animation: shimmer 2.8s linear 1.8s 2;
    }
    .success-btn:hover {
        background: #e09c0d;
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(253,181,21,.28);
    }

    /* ── Footer note ── */
    .success-note {
        margin-top: 22px;
        font-size: 12px;
        color: #3a3a3a;
        line-height: 1.7;
        animation: fadeIn .4s ease 1.5s both;
    }
    .success-note a { color: #FDB515; text-decoration: none; }
    .success-note a:hover { text-decoration: underline; }

    /* ── Floating dots (decorative) ── */
    .dot {
        position: absolute; border-radius: 50%;
        background: rgba(253,181,21,.45);
        pointer-events: none;
        animation: floatDot linear infinite;
    }
    @keyframes floatDot {
        0%   { transform: translateY(0) scale(1); opacity: .5; }
        50%  { opacity: .2; }
        100% { transform: translateY(-60px) scale(.5); opacity: 0; }
    }
</style>
@endpush

@section('content')
<div class="success-wrap">

    {{-- Icon with rings --}}
    <div class="success-icon-area" id="iconArea">
        <div class="success-ring-2"></div>
        <div class="success-ring-1"></div>
        <div class="success-circle">
            <svg class="check-svg" viewBox="0 0 48 48" fill="none">
                <path class="check-path" d="M12 25l9 9 15-18"/>
            </svg>
        </div>
    </div>

    <h1 class="success-title">Payment Successful</h1>
    <p class="success-sub">
        Your package is now active.<br>
        A confirmation email is on its way to
        <strong>{{ $userPackage->user->email }}</strong>
    </p>

    {{-- Order card --}}
    <div class="order-card">
        <div class="order-card-header">
            <span class="order-card-label">Order Summary</span>
            <span class="order-card-badge">
                <svg width="8" height="8" fill="none" viewBox="0 0 24 24"><path stroke="#00D15B" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg>
                Confirmed
            </span>
        </div>
        <div class="order-row">
            <span class="order-key">Package</span>
            <span class="order-val">{{ $userPackage->package->name }}</span>
        </div>
        <div class="order-row">
            <span class="order-key">Amount Charged</span>
            <span class="order-val gold">${{ number_format($userPackage->amount_paid, 2) }}</span>
        </div>
        <div class="order-row">
            <span class="order-key">Access Starts</span>
            <span class="order-val">{{ $userPackage->starts_at->format('M j, Y') }}</span>
        </div>
        <div class="order-row">
            <span class="order-key">Access Expires</span>
            <span class="order-val">{{ $userPackage->expires_at->format('M j, Y') }}</span>
        </div>
    </div>

    <a href="/subscriber/dashboard" class="success-btn">
        Go to Dashboard
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path stroke="#171818" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/></svg>
    </a>

    <p class="success-note">
        Questions? Email <a href="mailto:help@inspin.com">help@inspin.com</a>
        or call <a href="tel:+16108704799">610-870-4799</a>
    </p>
</div>

<script>
// Spawn small floating gold dots from the icon on load
document.addEventListener('DOMContentLoaded', function () {
    var area = document.getElementById('iconArea');
    var rect = area.getBoundingClientRect();
    var wrap = document.querySelector('.success-wrap');

    function spawnDot() {
        var d = document.createElement('div');
        d.className = 'dot';
        var size = 3 + Math.random() * 4;
        d.style.cssText = [
            'width:' + size + 'px',
            'height:' + size + 'px',
            'left:' + (area.offsetLeft + area.offsetWidth/2 + (Math.random()-0.5)*60) + 'px',
            'top:' + (area.offsetTop + area.offsetHeight/2 + (Math.random()-0.5)*30) + 'px',
            'animation-duration:' + (1.2 + Math.random() * 1.2) + 's',
            'animation-delay:' + (Math.random() * .4) + 's',
        ].join(';');
        wrap.style.position = 'relative';
        wrap.appendChild(d);
        setTimeout(function() { d.remove(); }, 2400);
    }

    // burst of dots when checkmark finishes drawing (~1.2s)
    setTimeout(function () {
        for (var i = 0; i < 14; i++) {
            setTimeout(spawnDot, i * 60);
        }
    }, 1150);
});
</script>
@endsection
