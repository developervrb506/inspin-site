@extends('layouts.subscriber')
@section('title', 'Cashier - INSPIN')
@section('page-title', 'Cashier')

@push('styles')
<style>
    /* ── Entrance animations ── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes glowPulse {
        0%,100% { box-shadow: 0 0 0 0 rgba(253,181,21,.0); }
        50%      { box-shadow: 0 0 0 5px rgba(253,181,21,.12); }
    }
    @keyframes checkPop {
        0%   { transform: scale(0); opacity: 0; }
        60%  { transform: scale(1.25); }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes summaryIn {
        from { opacity: 0; transform: translateX(-6px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    /* ── Layout ── */
    .cashier-outer { display: flex; gap: 28px; align-items: flex-start; }
    .cashier-left  { flex: 1; min-width: 0; }
    .cashier-right { width: 320px; flex-shrink: 0; position: sticky; top: 24px; }
    @media (max-width: 900px) {
        .cashier-outer { flex-direction: column; }
        .cashier-right { width: 100%; position: static; }
    }

    /* ── Section label ── */
    .section-label {
        display: block; font-size: 10.5px; color: #555; text-transform: uppercase;
        letter-spacing: .7px; font-weight: 700; margin-bottom: 14px;
    }

    /* ── Package grid ── */
    .pkg-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }
    @media (max-width: 700px) { .pkg-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 420px) { .pkg-grid { grid-template-columns: 1fr; } }

    .pkg-card {
        background: #191919;
        border: 1.5px solid rgba(255,252,238,.07);
        border-radius: 16px;
        padding: 20px 18px 18px;
        cursor: pointer;
        position: relative;
        display: flex;
        flex-direction: column;
        user-select: none;
        transition: border-color .2s, background .2s, transform .2s, box-shadow .2s;
        animation: fadeUp .4s ease both;
    }
    /* stagger each card */
    .pkg-card:nth-child(1) { animation-delay: .04s; }
    .pkg-card:nth-child(2) { animation-delay: .08s; }
    .pkg-card:nth-child(3) { animation-delay: .12s; }
    .pkg-card:nth-child(4) { animation-delay: .16s; }
    .pkg-card:nth-child(5) { animation-delay: .20s; }
    .pkg-card:nth-child(6) { animation-delay: .24s; }
    .pkg-card:nth-child(7) { animation-delay: .28s; }
    .pkg-card:nth-child(8) { animation-delay: .32s; }
    .pkg-card:nth-child(9) { animation-delay: .36s; }

    .pkg-card:hover {
        border-color: rgba(253,181,21,.3);
        background: #1d1d1d;
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0,0,0,.35);
    }
    .pkg-card.selected {
        border-color: #FDB515;
        background: rgba(253,181,21,.04);
        animation: glowPulse 1.8s ease 1;
    }
    .pkg-card.selected:hover { transform: translateY(-2px); }

    /* badge row — fixed height so cards align */
    .pkg-badge-row { height: 22px; margin-bottom: 12px; }
    .pkg-badge {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
        background: rgba(253,181,21,.1); color: #FDB515;
        border: 1px solid rgba(253,181,21,.25); border-radius: 20px;
        padding: 3px 9px; line-height: 1;
    }

    .pkg-name     { font-size: 14px; font-weight: 700; color: #FFFCEE; margin-bottom: 3px; }
    .pkg-duration { font-size: 11.5px; color: #555; margin-bottom: 16px; flex: 1; }
    .pkg-price    { font-size: 23px; font-weight: 700; color: #FDB515; font-family: 'Clash Display', sans-serif; line-height: 1; }
    .pkg-price-sub{ font-size: 10.5px; color: #555; margin-top: 4px; font-family: 'DM Sans', sans-serif; }

    /* checkmark */
    .pkg-check {
        display: none;
        position: absolute; top: 12px; right: 12px;
        width: 22px; height: 22px;
        background: #FDB515; border-radius: 50%;
        align-items: center; justify-content: center;
    }
    .pkg-card.selected .pkg-check {
        display: flex;
        animation: checkPop .25s cubic-bezier(.34,1.56,.64,1) both;
    }

    /* ── Right panel ── */
    .panel-card {
        background: #191919;
        border: 1px solid rgba(255,252,238,.07);
        border-radius: 16px;
        padding: 22px;
        margin-bottom: 16px;
        animation: fadeUp .4s ease .1s both;
    }

    .order-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 10px 0;
    }
    .order-row + .order-row { border-top: 1px solid rgba(255,252,238,.05); }
    .order-key { font-size: 12.5px; color: #555; }
    .order-val { font-size: 13px; color: #FFFCEE; font-weight: 600; text-align: right; max-width: 60%; }
    .order-val.updating { animation: summaryIn .2s ease both; }
    .order-total-row { padding-top: 14px; margin-top: 4px; border-top: 1px solid rgba(255,252,238,.08) !important; }
    .order-total-key { font-size: 13.5px; color: #FFFCEE; font-weight: 700; }
    .order-total-val {
        font-size: 26px; font-weight: 700; color: #FDB515;
        font-family: 'Clash Display', sans-serif; line-height: 1;
    }

    /* ── Payment method ── */
    .pay-method {
        display: flex; align-items: center; gap: 11px;
        background: #141414; border: 1.5px solid rgba(255,252,238,.06);
        border-radius: 11px; padding: 12px 14px;
        margin-bottom: 10px; position: relative; opacity: .4;
        transition: opacity .2s, border-color .2s;
    }
    .pay-method.active { opacity: 1; border-color: rgba(253,181,21,.3); }
    .pay-icon { font-size: 19px; line-height: 1; flex-shrink: 0; }
    .pay-name { font-size: 12.5px; font-weight: 600; color: #FFFCEE; }
    .pay-sub  { font-size: 10.5px; color: #555; margin-top: 1px; }
    .pay-soon {
        position: absolute; top: 8px; right: 10px;
        font-size: 8.5px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px;
        background: rgba(253,181,21,.07); color: #FDB515;
        border: 1px solid rgba(253,181,21,.18); border-radius: 20px; padding: 2px 7px;
    }

    /* ── CTA button ── */
    .cashier-btn {
        width: 100%; padding: 16px; background: #FDB515;
        color: #171818; border: none; border-radius: 12px;
        font-weight: 700; font-size: 14.5px; cursor: pointer;
        font-family: 'DM Sans', sans-serif;
        display: flex; align-items: center; justify-content: center; gap: 8px;
        transition: background .15s, transform .15s, box-shadow .15s;
        letter-spacing: .1px; margin-bottom: 14px;
    }
    .cashier-btn:hover:not(:disabled) {
        background: #e09c0d;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(253,181,21,.25);
    }
    .cashier-btn:active:not(:disabled) { transform: translateY(0); }
    .cashier-btn:disabled { opacity: .4; cursor: not-allowed; }

    /* ── Trust bar ── */
    .trust-bar { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
    .trust-item {
        display: flex; align-items: center; gap: 6px;
        font-size: 10.5px; color: #444; line-height: 1.3;
    }

    /* ── Alerts ── */
    .alert-error {
        background: rgba(239,68,68,.07); border: 1px solid rgba(239,68,68,.2);
        border-radius: 10px; padding: 13px 16px; margin-bottom: 20px;
        color: #f87171; font-size: 13px;
    }
    .alert-warn {
        background: rgba(253,181,21,.05); border: 1px solid rgba(253,181,21,.15);
        border-radius: 10px; padding: 13px 16px; margin-bottom: 20px;
        color: #FDB515; font-size: 13px;
    }

    /* ── Empty state placeholder ── */
    .pkg-placeholder {
        color: #3a3a3a; font-size: 13px; text-align: center;
        padding: 20px 0 4px; font-style: italic;
    }
</style>
@endpush

@section('content')

@if(session('error'))
<div class="alert-error">{{ session('error') }}</div>
@endif
@if(!$stripeConfigured)
<div class="alert-warn">Payment processing is being finalized. Checkout will be enabled shortly.</div>
@endif

<form method="POST" action="{{ route('cashier.checkout') }}" id="cashierForm">
    @csrf
    <input type="hidden" name="package_id" id="selectedPackageId" value="{{ $selectedPackageId ?? '' }}">

    <div class="cashier-outer">

        {{-- LEFT: Package cards --}}
        <div class="cashier-left">
            <span class="section-label">Select Your Package</span>
            <div class="pkg-grid">
                @foreach($packages as $package)
                @php $isPopular = $package->slug === 'monthly'; @endphp
                <div class="pkg-card {{ ($selectedPackageId == $package->id) ? 'selected' : '' }}"
                     data-id="{{ $package->id }}"
                     data-price="{{ number_format($package->price, 2) }}"
                     data-name="{{ $package->name }}"
                     data-duration="{{ $package->duration }}"
                     onclick="selectPackage(this)">

                    <div class="pkg-check">
                        <svg width="11" height="11" fill="none" viewBox="0 0 24 24"><path stroke="#171818" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg>
                    </div>

                    <div class="pkg-badge-row">
                        @if($isPopular)
                        <div class="pkg-badge">
                            <svg width="9" height="9" fill="#FDB515" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            Most Popular
                        </div>
                        @endif
                    </div>

                    <div class="pkg-name">{{ $package->name }}</div>
                    <div class="pkg-duration">{{ $package->duration }} access</div>
                    <div class="pkg-price">${{ number_format($package->price, 2) }}</div>
                    <div class="pkg-price-sub">one-time · no renewal</div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- RIGHT: Order summary + payment --}}
        <div class="cashier-right">

            {{-- Order summary --}}
            <div class="panel-card">
                <span class="section-label" style="margin-bottom:12px;">Order Summary</span>

                <div class="order-row">
                    <span class="order-key">Package</span>
                    <span class="order-val" id="summaryPackage" style="color:#3a3a3a;font-weight:400;font-style:italic;">None selected</span>
                </div>
                <div class="order-row">
                    <span class="order-key">Duration</span>
                    <span class="order-val" id="summaryDuration" style="color:#3a3a3a;font-weight:400;">—</span>
                </div>
                <div class="order-row">
                    <span class="order-key">Billing</span>
                    <span class="order-val">One-time charge</span>
                </div>
                <div class="order-row order-total-row">
                    <span class="order-total-key">Total Due</span>
                    <span class="order-total-val" id="summaryTotal">—</span>
                </div>
            </div>

            {{-- Payment method --}}
            <div class="panel-card" style="padding:18px 20px;">
                <span class="section-label" style="margin-bottom:12px;">Payment Method</span>
                <div class="pay-method active">
                    <div class="pay-icon">💳</div>
                    <div>
                        <div class="pay-name">Credit / Debit Card</div>
                        <div class="pay-sub">Visa, Mastercard, Amex via Stripe</div>
                    </div>
                </div>
                <div class="pay-method">
                    <div class="pay-icon">₿</div>
                    <div>
                        <div class="pay-name">Bitcoin</div>
                        <div class="pay-sub">Crypto deposit</div>
                    </div>
                    <span class="pay-soon">Soon</span>
                </div>
            </div>

            {{-- CTA --}}
            <button type="submit" class="cashier-btn" id="checkoutBtn" {{ $stripeConfigured ? '' : 'disabled' }}>
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path stroke="#171818" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                {{ $stripeConfigured ? 'Continue to Secure Checkout' : 'Checkout Coming Soon' }}
            </button>

            <div class="trust-bar">
                <div class="trust-item">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" stroke="#444" stroke-width="2"/><path stroke="#444" stroke-width="2" stroke-linecap="round" d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    SSL Encrypted
                </div>
                <div class="trust-item">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24"><path stroke="#444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Powered by Stripe
                </div>
                <div class="trust-item">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#444" stroke-width="2"/><path stroke="#444" stroke-width="2" stroke-linecap="round" d="M12 8v4l3 3"/></svg>
                    No Recurring Fees
                </div>
                <div class="trust-item">
                    <svg width="12" height="12" fill="none" viewBox="0 0 24 24"><path stroke="#444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    PCI Compliant
                </div>
            </div>

        </div>{{-- /cashier-right --}}
    </div>{{-- /cashier-outer --}}
</form>

<script>
function animateVal(el) {
    el.classList.remove('updating');
    void el.offsetWidth;
    el.classList.add('updating');
}
function selectPackage(el) {
    document.querySelectorAll('.pkg-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('selectedPackageId').value = el.dataset.id;

    var pkg  = document.getElementById('summaryPackage');
    var dur  = document.getElementById('summaryDuration');
    var tot  = document.getElementById('summaryTotal');

    pkg.textContent = el.dataset.name;
    pkg.style.color = '#FFFCEE';
    pkg.style.fontWeight = '600';
    pkg.style.fontStyle = 'normal';
    animateVal(pkg);

    dur.textContent = el.dataset.duration;
    dur.style.color = '#FFFCEE';
    animateVal(dur);

    tot.textContent = '$' + el.dataset.price;
    animateVal(tot);
}
document.addEventListener('DOMContentLoaded', function () {
    var pre = document.querySelector('.pkg-card.selected');
    if (pre) selectPackage(pre);

    document.getElementById('cashierForm').addEventListener('submit', function(e) {
        if (!document.getElementById('selectedPackageId').value) {
            e.preventDefault();
            // shake the grid
            var grid = document.querySelector('.pkg-grid');
            grid.style.transition = 'transform .08s';
            [0,6,-6,6,-4,0].forEach(function(x, i) {
                setTimeout(function(){ grid.style.transform = 'translateX('+x+'px)'; }, i * 60);
            });
            setTimeout(function(){ grid.style.transform = ''; }, 400);
        }
    });
});
</script>
@endsection
