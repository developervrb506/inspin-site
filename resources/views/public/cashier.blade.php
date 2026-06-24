@extends('layouts.public')
@section('title', 'Cashier - INSPIN')

@section('content')
<style>
    .cashier-wrap { max-width: 680px; margin: 0 auto; padding: 60px 24px 80px; }
    .cashier-tabs { display: flex; gap: 8px; margin-bottom: 28px; background: #1e1e1e; border-radius: 12px; padding: 6px; }
    .cashier-tab {
        flex: 1; text-align: center; padding: 12px; border-radius: 9px;
        font-family: 'DM Sans', sans-serif; font-weight: 700; font-size: 14px;
        color: #9a9a9a; cursor: pointer; transition: all .18s; border: none; background: transparent;
    }
    .cashier-tab.active { background: #FDB515; color: #171818; }
    .cashier-card {
        background: #1e1e1e; border: 1px solid rgba(255,252,238,.07);
        border-radius: 16px; padding: 28px;
    }
    .cashier-label {
        font-size: 11px; color: #6e6e6e; text-transform: uppercase;
        letter-spacing: .5px; margin-bottom: 8px; font-weight: 600; display: block;
    }
    .cashier-amount-input {
        width: 100%; background: #171818; border: 1px solid rgba(255,252,238,.08);
        border-radius: 10px; padding: 16px 18px; color: #FFFCEE; font-size: 22px;
        font-weight: 700; font-family: 'DM Sans', sans-serif; outline: none;
        margin-bottom: 24px; transition: border-color .2s;
    }
    .cashier-amount-input:focus { border-color: rgba(253,181,21,.4); }
    .cashier-quick-amounts { display: flex; gap: 8px; margin-bottom: 28px; flex-wrap: wrap; }
    .cashier-quick-amt {
        padding: 8px 16px; background: #171818; border: 1px solid rgba(255,252,238,.08);
        border-radius: 50px; color: #9a9a9a; font-size: 13px; font-weight: 600;
        cursor: pointer; transition: all .18s;
    }
    .cashier-quick-amt:hover { border-color: rgba(253,181,21,.3); color: #FDB515; }
    .cashier-methods { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 28px; }
    @media (max-width: 520px) { .cashier-methods { grid-template-columns: 1fr; } }
    .cashier-method {
        display: flex; align-items: center; gap: 12px;
        background: #171818; border: 1px solid rgba(255,252,238,.07);
        border-radius: 12px; padding: 16px; cursor: pointer;
        transition: all .18s; position: relative; opacity: .55;
    }
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
        width: 100%; padding: 16px; background: rgba(253,181,21,.15);
        color: #FDB515; border: 1px solid rgba(253,181,21,.25); border-radius: 12px;
        font-weight: 700; font-size: 15px; cursor: not-allowed;
        font-family: 'DM Sans', sans-serif; text-align: center;
    }
    .cashier-note {
        text-align: center; font-size: 12.5px; color: #6e6e6e;
        margin-top: 16px; line-height: 1.6;
    }
</style>

<div class="cashier-wrap">
    <h1 class="section-title" style="text-align:center;border-left:none;padding-left:0;">Cashier</h1>
    <p class="section-sub" style="text-align:center;padding-left:0;">Manage deposits and withdrawals — secure, fast, and on your terms.</p>

    <div class="cashier-tabs">
        <button type="button" class="cashier-tab active" onclick="setCashierTab('deposit', this)">Deposit</button>
        <button type="button" class="cashier-tab" onclick="setCashierTab('withdraw', this)">Withdraw</button>
    </div>

    <div class="cashier-card">
        <label class="cashier-label" id="cashierAmountLabel">Deposit Amount</label>
        <input type="text" class="cashier-amount-input" placeholder="$0.00" disabled>

        <div class="cashier-quick-amounts">
            <span class="cashier-quick-amt">$50</span>
            <span class="cashier-quick-amt">$100</span>
            <span class="cashier-quick-amt">$250</span>
            <span class="cashier-quick-amt">$500</span>
        </div>

        <label class="cashier-label">Payment Method</label>
        <div class="cashier-methods">
            <div class="cashier-method">
                <div class="cashier-method-icon">💳</div>
                <div>
                    <div class="cashier-method-name">Credit / Debit Card</div>
                    <div class="cashier-method-sub">Visa, Mastercard, Amex</div>
                </div>
                <span class="cashier-method-soon">Soon</span>
            </div>
            <div class="cashier-method">
                <div class="cashier-method-icon">₿</div>
                <div>
                    <div class="cashier-method-name">Bitcoin</div>
                    <div class="cashier-method-sub">Crypto deposit</div>
                </div>
                <span class="cashier-method-soon">Soon</span>
            </div>
            <div class="cashier-method">
                <div class="cashier-method-icon">🏦</div>
                <div>
                    <div class="cashier-method-name">Bank Transfer</div>
                    <div class="cashier-method-sub">ACH / Wire</div>
                </div>
                <span class="cashier-method-soon">Soon</span>
            </div>
            <div class="cashier-method">
                <div class="cashier-method-icon">📱</div>
                <div>
                    <div class="cashier-method-name">CashApp / Venmo</div>
                    <div class="cashier-method-sub">P2P transfer</div>
                </div>
                <span class="cashier-method-soon">Soon</span>
            </div>
        </div>

        <div class="cashier-submit">Cashier Coming Soon</div>
        <p class="cashier-note">We're finalizing secure payment processing. Once live, you'll be able to deposit and withdraw funds directly from this page.</p>
    </div>
</div>

<script>
function setCashierTab(tab, btn) {
    document.querySelectorAll('.cashier-tab').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    document.getElementById('cashierAmountLabel').textContent = tab === 'deposit' ? 'Deposit Amount' : 'Withdraw Amount';
}
</script>
@endsection
