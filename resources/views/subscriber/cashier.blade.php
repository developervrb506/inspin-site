@extends('layouts.subscriber')
@section('title', 'Cashier - INSPIN')
@section('page-title', 'Cashier')

@push('styles')
<style>
    .cashier-wrap { max-width: 780px; }

    .section-label {
        font-size: 11px; color: #6e6e6e; text-transform: uppercase;
        letter-spacing: .6px; font-weight: 600; margin-bottom: 14px; display: block;
    }

    /* Package grid */
    .pkg-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 28px;
    }
    @media (max-width: 660px) { .pkg-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 400px) { .pkg-grid { grid-template-columns: 1fr; } }

    .pkg-card {
        background: #1a1a1a;
        border: 1.5px solid rgba(255,252,238,.07);
        border-radius: 14px;
        padding: 18px 16px 16px;
        cursor: pointer;
        transition: border-color .15s, background .15s, transform .1s;
        position: relative;
        user-select: none;
    }
    .pkg-card:hover {
        border-color: rgba(253,181,21,.3);
        background: #1e1e1e;
        transform: translateY(-1px);
    }
    .pkg-card.selected {
        border-color: #FDB515;
        background: rgba(253,181,21,.04);
    }
    .pkg-check {
        display: none;
        position: absolute;
        top: 10px; right: 10px;
        width: 20px; height: 20px;
        background: #FDB515;
        border-radius: 50%;
        align-items: center; justify-content: center;
    }
    .pkg-card.selected .pkg-check { display: flex; }
    .pkg-badge {
        display: inline-block;
        font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
        background: rgba(253,181,21,.12); color: #FDB515;
        border: 1px solid rgba(253,181,21,.25); border-radius: 20px;
        padding: 2px 8px; margin-bottom: 10px;
    }
    .pkg-name { font-size: 13px; font-weight: 600; color: #FFFCEE; margin-bottom: 3px; }
    .pkg-duration { font-size: 11.5px; color: #6e6e6e; margin-bottom: 14px; }
    .pkg-price {
        font-size: 21px; font-weight: 700; color: #FDB515;
        font-family: 'Clash Display', sans-serif; line-height: 1;
    }
    .pkg-price-sub { font-size: 11px; color: #6e6e6e; font-weight: 400; font-family: 'DM Sans', sans-serif; margin-top: 3px; }

    /* Order summary */
    .order-card {
        background: #1a1a1a;
        border: 1px solid rgba(255,252,238,.07);
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 20px;
    }
    .order-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 10px 0;
    }
    .order-row + .order-row { border-top: 1px solid rgba(255,252,238,.05); }
    .order-key { font-size: 13px; color: #6e6e6e; }
    .order-val { font-size: 13.5px; color: #FFFCEE; font-weight: 600; }
    .order-total-key { font-size: 14px; color: #FFFCEE; font-weight: 600; }
    .order-total-val { font-size: 24px; font-weight: 700; color: #FDB515; font-family: 'Clash Display', sans-serif; }

    /* Payment method */
    .pay-methods { display: flex; gap: 10px; margin-bottom: 24px; }
    @media (max-width: 440px) { .pay-methods { flex-direction: column; } }
    .pay-method {
        flex: 1; display: flex; align-items: center; gap: 11px;
        background: #1a1a1a; border: 1.5px solid rgba(255,252,238,.07);
        border-radius: 12px; padding: 14px 16px; position: relative; opacity: .45;
    }
    .pay-method.active { opacity: 1; border-color: rgba(253,181,21,.35); }
    .pay-icon { font-size: 20px; line-height: 1; }
    .pay-name { font-size: 13px; font-weight: 600; color: #FFFCEE; }
    .pay-sub { font-size: 11px; color: #6e6e6e; margin-top: 1px; }
    .pay-soon {
        position: absolute; top: 8px; right: 10px;
        font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .4px;
        background: rgba(253,181,21,.08); color: #FDB515;
        border: 1px solid rgba(253,181,21,.2); border-radius: 20px; padding: 2px 7px;
    }

    /* CTA */
    .cashier-btn {
        width: 100%; padding: 17px; background: #FDB515;
        color: #171818; border: none; border-radius: 13px;
        font-weight: 700; font-size: 15.5px; cursor: pointer;
        font-family: 'DM Sans', sans-serif; transition: background .15s;
        display: flex; align-items: center; justify-content: center; gap: 9px;
        letter-spacing: .1px;
    }
    .cashier-btn:hover { background: #e09c0d; }
    .cashier-btn:disabled { opacity: .45; cursor: not-allowed; }

    /* Trust bar */
    .trust-bar {
        display: flex; align-items: center; justify-content: center;
        gap: 22px; margin-top: 16px; flex-wrap: wrap;
    }
    .trust-item { display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: #4a4a4a; }

    /* Alerts */
    .alert-error {
        background: rgba(239,68,68,.07); border: 1px solid rgba(239,68,68,.2);
        border-radius: 10px; padding: 13px 18px; margin-bottom: 20px;
        color: #f87171; font-size: 13.5px;
    }
    .alert-warn {
        background: rgba(253,181,21,.05); border: 1px solid rgba(253,181,21,.18);
        border-radius: 10px; padding: 13px 18px; margin-bottom: 20px;
        color: #FDB515; font-size: 13.5px;
    }
</style>
@endpush

@section('content')
<div class="cashier-wrap">

    @if(session('error'))
    <div class="alert-error">{{ session('error') }}</div>
    @endif

    @if(!$stripeConfigured)
    <div class="alert-warn">Payment processing is being finalized. Checkout will be enabled shortly.</div>
    @endif

    <form method="POST" action="{{ route('cashier.checkout') }}" id="cashierForm">
        @csrf
        <input type="hidden" name="package_id" id="selectedPackageId" value="{{ $selectedPackageId ?? '' }}">

        {{-- Package Cards --}}
        <span class="section-label">Select Your Package</span>
        <div class="pkg-grid">
            @foreach($packages as $package)
            @php $isPopular = $package->slug === 'monthly'; @endphp
            <div class="pkg-card {{ ($selectedPackageId == $package->id) ? 'selected' : '' }}"
                 data-id="{{ $package->id }}"
                 data-price="{{ number_format($package->price, 2) }}"
                 data-name="{{ $package->name }}"
                 onclick="selectPackage(this)">
                <div class="pkg-check">
                    <svg width="11" height="11" fill="none" viewBox="0 0 24 24"><path stroke="#171818" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg>
                </div>
                @if($isPopular)
                <div class="pkg-badge">Most Popular</div>
                @else
                <div style="height:20px;margin-bottom:10px;"></div>
                @endif
                <div class="pkg-name">{{ $package->name }}</div>
                <div class="pkg-duration">{{ $package->duration }} access</div>
                <div class="pkg-price">${{ number_format($package->price, 2) }}</div>
                <div class="pkg-price-sub">one-time charge</div>
            </div>
            @endforeach
        </div>

        {{-- Order Summary --}}
        <span class="section-label">Order Summary</span>
        <div class="order-card">
            <div class="order-row">
                <span class="order-key">Package</span>
                <span class="order-val" id="summaryPackage" style="color:#9a9a9a;font-weight:400;">Select a package above</span>
            </div>
            <div class="order-row">
                <span class="order-key">Billing Type</span>
                <span class="order-val">One-time &nbsp;·&nbsp; No auto-renewal</span>
            </div>
            <div class="order-row">
                <span class="order-total-key">Total Due</span>
                <span class="order-total-val" id="summaryTotal">—</span>
            </div>
        </div>

        {{-- Payment Method --}}
        <span class="section-label">Payment Method</span>
        <div class="pay-methods">
            <div class="pay-method active">
                <div class="pay-icon">💳</div>
                <div>
                    <div class="pay-name">Credit / Debit Card</div>
                    <div class="pay-sub">Visa, Mastercard, Amex</div>
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

        <button type="submit" class="cashier-btn" id="checkoutBtn" {{ $stripeConfigured ? '' : 'disabled' }}>
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path stroke="#171818" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            {{ $stripeConfigured ? 'Continue to Secure Checkout' : 'Checkout Coming Soon' }}
        </button>

        <div class="trust-bar">
            <div class="trust-item">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" stroke="#4a4a4a" stroke-width="2"/><path stroke="#4a4a4a" stroke-width="2" stroke-linecap="round" d="M7 11V7a5 5 0 0110 0v4"/></svg>
                SSL Encrypted
            </div>
            <div class="trust-item">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path stroke="#4a4a4a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                Powered by Stripe
            </div>
            <div class="trust-item">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="#4a4a4a" stroke-width="2"/><path stroke="#4a4a4a" stroke-width="2" stroke-linecap="round" d="M12 8v4l3 3"/></svg>
                No Recurring Billing
            </div>
            <div class="trust-item">
                <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><path stroke="#4a4a4a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                PCI Compliant
            </div>
        </div>
    </form>
</div>

<script>
function selectPackage(el) {
    document.querySelectorAll('.pkg-card').forEach(c => c.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('selectedPackageId').value = el.dataset.id;
    var nameEl = document.getElementById('summaryPackage');
    nameEl.textContent = el.dataset.name;
    nameEl.style.color = '#FFFCEE';
    nameEl.style.fontWeight = '600';
    document.getElementById('summaryTotal').textContent = '$' + el.dataset.price;
}
document.addEventListener('DOMContentLoaded', function () {
    var pre = document.querySelector('.pkg-card.selected');
    if (pre) {
        var nameEl = document.getElementById('summaryPackage');
        nameEl.textContent = pre.dataset.name;
        nameEl.style.color = '#FFFCEE';
        nameEl.style.fontWeight = '600';
        document.getElementById('summaryTotal').textContent = '$' + pre.dataset.price;
    }
    document.getElementById('cashierForm').addEventListener('submit', function(e) {
        if (!document.getElementById('selectedPackageId').value) {
            e.preventDefault();
            alert('Please select a package to continue.');
        }
    });
});
</script>
@endsection
