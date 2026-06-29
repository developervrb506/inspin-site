@extends('layouts.public')
@section('title', 'Cashier - INSPIN')

@section('content')
<style>
    .cashier-wrap { max-width: 680px; margin: 0 auto; padding: 60px 24px 80px; }
    .cashier-card {
        background: #1e1e1e; border: 1px solid rgba(255,252,238,.07);
        border-radius: 16px; padding: 28px;
    }
    .cashier-label {
        font-size: 11px; color: #6e6e6e; text-transform: uppercase;
        letter-spacing: .5px; margin-bottom: 8px; font-weight: 600; display: block;
    }
    .cashier-select {
        width: 100%; background: #171818; border: 1px solid rgba(255,252,238,.08);
        border-radius: 10px; padding: 16px 18px; color: #FFFCEE; font-size: 15px;
        font-weight: 600; font-family: 'DM Sans', sans-serif; outline: none;
        margin-bottom: 24px; transition: border-color .2s; cursor: pointer; appearance: none;
    }
    .cashier-select:focus { border-color: rgba(253,181,21,.4); }
    .cashier-methods { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 28px; }
    @media (max-width: 520px) { .cashier-methods { grid-template-columns: 1fr; } }
    .cashier-method {
        display: flex; align-items: center; gap: 12px;
        background: #171818; border: 1px solid rgba(255,252,238,.07);
        border-radius: 12px; padding: 16px; position: relative; opacity: .55;
    }
    .cashier-method.is-active { opacity: 1; border-color: rgba(253,181,21,.3); }
    .cashier-method-icon {
        width: 38px; height: 38px; border-radius: 9px;
        background: rgba(253,181,21,.08); display: flex;
        align-items: center; justify-content: center; font-size: 19px; flex-shrink: 0;
    }
    .cashier-method-name { font-size: 14px; font-weight: 600; color: #FFFCEE; }
    .cashier-method-sub { font-size: 11px; color: #6e6e6e; margin-top: 1px; }
    .cashier-method-soon {
        position: absolute; top: 10px; right: 10px;
        font-size: 9px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
        background: rgba(253,181,21,.1); color: #FDB515;
        border: 1px solid rgba(253,181,21,.2); border-radius: 20px; padding: 2px 8px;
    }
    .cashier-submit {
        width: 100%; padding: 16px; background: #FDB515;
        color: #171818; border: none; border-radius: 12px;
        font-weight: 700; font-size: 15px; cursor: pointer;
        font-family: 'DM Sans', sans-serif; text-align: center; transition: background .15s;
    }
    .cashier-submit:hover { background: #e09c0d; }
    .cashier-submit:disabled { opacity: .5; cursor: not-allowed; }
    .cashier-note {
        text-align: center; font-size: 12.5px; color: #6e6e6e;
        margin-top: 16px; line-height: 1.6;
    }
    .cashier-price-line {
        display: flex; justify-content: space-between; align-items: baseline;
        padding: 14px 0; border-top: 1px solid rgba(255,252,238,.06);
        margin-bottom: 20px;
    }
    .cashier-price-label { font-size: 13px; color: #9a9a9a; }
    .cashier-price-amount { font-size: 24px; font-weight: 700; color: #FDB515; font-family: 'Clash Display', sans-serif; }
</style>

<div class="cashier-wrap">
    <h1 class="section-title" style="text-align:center;border-left:none;padding-left:0;">Cashier</h1>
    <p class="section-sub" style="text-align:center;padding-left:0;">Choose your package and check out securely.</p>

    @if(session('error'))
    <div style="background:rgba(239,68,68,.08);border:1px solid rgba(239,68,68,.25);border-radius:10px;padding:14px 18px;margin-bottom:20px;color:#f87171;font-size:13.5px;">
        {{ session('error') }}
    </div>
    @endif

    @if(!$stripeConfigured)
    <div style="background:rgba(253,181,21,.06);border:1px solid rgba(253,181,21,.2);border-radius:10px;padding:14px 18px;margin-bottom:20px;color:#FDB515;font-size:13.5px;">
        Payment processing is being finalized. Checkout will be enabled shortly.
    </div>
    @endif

    <form method="POST" action="{{ route('cashier.checkout') }}">
        @csrf
        <div class="cashier-card">
            <label class="cashier-label" for="package_id">Select Your Package</label>
            <select name="package_id" id="package_id" class="cashier-select" required onchange="updateCashierPrice(this)">
                <option value="" disabled {{ $selectedPackageId ? '' : 'selected' }}>Choose a package…</option>
                @foreach($packages as $package)
                <option value="{{ $package->id }}" data-price="{{ number_format($package->price, 2) }}" {{ $selectedPackageId == $package->id ? 'selected' : '' }}>
                    {{ $package->name }} — ${{ number_format($package->price, 2) }} ({{ $package->duration }})
                </option>
                @endforeach
            </select>

            <div class="cashier-price-line">
                <span class="cashier-price-label">Total — one-time charge</span>
                <span class="cashier-price-amount" id="cashierPriceDisplay">$0.00</span>
            </div>

            <label class="cashier-label">Payment Method</label>
            <div class="cashier-methods">
                <div class="cashier-method is-active">
                    <div class="cashier-method-icon">💳</div>
                    <div>
                        <div class="cashier-method-name">Credit / Debit Card</div>
                        <div class="cashier-method-sub">Visa, Mastercard, Amex via Stripe</div>
                    </div>
                </div>
                <div class="cashier-method">
                    <div class="cashier-method-icon">₿</div>
                    <div>
                        <div class="cashier-method-name">Bitcoin</div>
                        <div class="cashier-method-sub">Crypto deposit</div>
                    </div>
                    <span class="cashier-method-soon">Soon</span>
                </div>
            </div>

            <button type="submit" class="cashier-submit" {{ $stripeConfigured ? '' : 'disabled' }}>
                {{ $stripeConfigured ? 'Continue to Secure Checkout' : 'Checkout Coming Soon' }}
            </button>
            <p class="cashier-note">
                You'll be redirected to Stripe's secure checkout to enter your card details. INSPIN never sees or stores your full card number.
                This is a one-time charge — no recurring billing, ever.
            </p>
        </div>
    </form>
</div>

<script>
function updateCashierPrice(select) {
    var opt = select.options[select.selectedIndex];
    var price = opt && opt.dataset.price ? parseFloat(opt.dataset.price) : 0;
    document.getElementById('cashierPriceDisplay').textContent = '$' + price.toFixed(2);
}
document.addEventListener('DOMContentLoaded', function () {
    updateCashierPrice(document.getElementById('package_id'));
});
</script>
@endsection
