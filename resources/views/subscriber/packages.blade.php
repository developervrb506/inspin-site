@extends('layouts.subscriber')
@section('title', 'Membership Packages - INSPIN')
@section('page-title', 'Membership Packages')

@push('styles')
<style>
    @keyframes fadeUp { from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:translateY(0)} }
    @keyframes fadeIn { from{opacity:0}to{opacity:1} }

    /* ── Notices ── */
    .notice-expired {
        display:flex; align-items:flex-start; gap:14px;
        background:rgba(239,68,68,.07); border:1px solid rgba(239,68,68,.2);
        border-radius:12px; padding:18px 22px; margin-bottom:24px;
        animation:fadeUp .4s ease both;
    }
    .notice-plan {
        display:flex; align-items:center; gap:12px;
        background:rgba(253,181,21,.05); border:1px solid rgba(253,181,21,.15);
        border-radius:12px; padding:14px 20px; margin-bottom:24px;
        animation:fadeUp .4s ease both;
    }

    /* ── Section divider ── */
    .section-divider {
        display:flex; align-items:center; gap:12px;
        font-size:10px; color:#3a3a3a; text-transform:uppercase;
        letter-spacing:.7px; font-weight:700; margin:28px 0 16px;
    }
    .section-divider::before, .section-divider::after {
        content:''; flex:1; height:1px; background:rgba(255,252,238,.05);
    }

    /* ── Free trial banner ── */
    .trial-banner {
        display:flex; align-items:center; justify-content:space-between; gap:20px;
        background:#141414; border:1.5px solid rgba(74,222,128,.2);
        border-radius:16px; padding:20px 26px; margin-bottom:8px;
        position:relative; overflow:hidden; flex-wrap:wrap;
        animation:fadeUp .4s ease .05s both;
    }
    .trial-banner::after {
        content:''; position:absolute; right:0; top:0; bottom:0; width:280px;
        background:radial-gradient(ellipse at right center,rgba(74,222,128,.06) 0%,transparent 70%);
        pointer-events:none;
    }
    .trial-badge {
        display:inline-flex; align-items:center; gap:5px;
        font-size:9px; font-weight:800; text-transform:uppercase; letter-spacing:.5px;
        background:rgba(74,222,128,.1); color:#4ade80;
        border:1px solid rgba(74,222,128,.25); border-radius:20px; padding:3px 10px;
        margin-bottom:8px;
    }
    .trial-title { font-family:'Clash Display',sans-serif; font-size:1.6rem; font-weight:700; color:#FFFCEE; line-height:1; margin-bottom:4px; }
    .trial-sub   { font-size:12.5px; color:#555; }
    .trial-features { display:flex; gap:16px; flex-wrap:wrap; margin-top:10px; }
    .trial-feat  { display:flex; align-items:center; gap:6px; font-size:12px; color:#6e6e6e; }

    /* ── Package grid ── */
    .packages-grid {
        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:12px;
        margin-bottom:8px;
    }
    @media(max-width:1100px){ .packages-grid { grid-template-columns:repeat(3,1fr); } }
    @media(max-width:760px) { .packages-grid { grid-template-columns:repeat(2,1fr); } }
    @media(max-width:460px) { .packages-grid { grid-template-columns:1fr; } }

    /* ── Package card ── */
    .pkg-card {
        background:#141414;
        border:1.5px solid rgba(255,252,238,.07);
        border-radius:14px;
        padding:18px 16px 16px;
        position:relative;
        display:flex; flex-direction:column;
        transition:border-color .2s, box-shadow .2s, transform .18s;
        animation:fadeUp .4s ease both;
    }
    .pkg-card:hover {
        border-color:rgba(253,181,21,.3);
        transform:translateY(-2px);
        box-shadow:0 8px 22px rgba(0,0,0,.45);
    }
    .pkg-card.is-current { border-color:rgba(253,181,21,.35); background:rgba(253,181,21,.02); }

    /* badge slot — fixed height keeps all cards aligned */
    .card-badge-row { height:22px; margin-bottom:12px; display:flex; align-items:center; }
    .card-badge {
        display:inline-flex; align-items:center; gap:4px;
        font-size:8.5px; font-weight:800; text-transform:uppercase; letter-spacing:.5px;
        border-radius:20px; padding:2px 9px; line-height:1; white-space:nowrap;
    }
    .badge-gold  { background:rgba(253,181,21,.1); color:#FDB515; border:1px solid rgba(253,181,21,.22); }
    .badge-teal  { background:rgba(45,212,191,.1);  color:#2dd4bf; border:1px solid rgba(45,212,191,.22); }
    .badge-green { background:rgba(74,222,128,.1);  color:#4ade80; border:1px solid rgba(74,222,128,.22); }

    /* absolute top badge (CURRENT PLAN) */
    .card-top-badge {
        position:absolute; top:-10px; left:50%; transform:translateX(-50%);
        font-size:8.5px; font-weight:800; text-transform:uppercase; letter-spacing:.5px;
        padding:3px 12px; border-radius:20px; white-space:nowrap;
    }

    .card-duration  { font-size:10px; color:#555; letter-spacing:.3px; margin-bottom:4px; }
    .card-name      { font-size:15px; font-weight:700; color:#FFFCEE; margin-bottom:14px; }
    .card-price     { font-family:'Clash Display',sans-serif; font-size:27px; font-weight:700; color:#FDB515; line-height:1; margin-bottom:2px; }
    .card-price sup { font-size:13px; color:#777; vertical-align:top; margin-top:5px; font-family:'DM Sans',sans-serif; font-weight:400; }
    .card-perday    { font-size:10.5px; color:#3a3a3a; margin-bottom:14px; }

    .card-tier {
        background:rgba(253,181,21,.04); border:1px solid rgba(253,181,21,.1);
        border-radius:8px; padding:7px 10px; text-align:center; margin-bottom:14px;
    }
    .card-tier-label { font-size:8.5px; color:#4a4a4a; text-transform:uppercase; letter-spacing:.4px; display:block; margin-bottom:2px; }
    .card-tier-val   { font-size:12.5px; color:#FDB515; font-weight:700; }

    /* CTA */
    .card-cta {
        display:flex; align-items:center; justify-content:center;
        width:100%; padding:10px 12px; border-radius:9px;
        font-size:13px; font-weight:700; cursor:pointer; text-decoration:none;
        transition:background .15s, box-shadow .15s; margin-top:auto;
        font-family:'DM Sans',sans-serif; border:none;
    }
    .cta-outline { border:1.5px solid #FDB515 !important; color:#FDB515; background:transparent; }
    .cta-outline:hover { background:rgba(253,181,21,.08); box-shadow:0 0 14px rgba(253,181,21,.15); }
    .cta-solid   { background:#FDB515; color:#171818; border:1.5px solid #FDB515 !important; }
    .cta-solid:hover { background:#e09c0d; }
    .cta-current { background:rgba(253,181,21,.07); color:#FDB515; border:1.5px solid rgba(253,181,21,.2) !important; cursor:default; }
    .cta-trial   { background:transparent; color:#4ade80; border:1.5px solid #22c55e !important; }
    .cta-trial:hover { background:rgba(34,197,94,.08); }
    .cta-locked  { background:rgba(255,255,255,.02); color:#3a3a3a; border:1.5px solid rgba(255,255,255,.06) !important; cursor:not-allowed; }

    /* ── Whale card ── */
    .whale-card {
        display:flex; align-items:center; justify-content:space-between; gap:24px;
        background:#141414; border:1.5px solid rgba(253,181,21,.18);
        border-radius:16px; padding:26px 30px; position:relative; overflow:hidden;
        flex-wrap:wrap; animation:fadeUp .4s ease .3s both;
        box-shadow:0 0 40px rgba(253,181,21,.04);
    }
    .whale-card::before {
        content:''; position:absolute; right:0; top:0; bottom:0; width:300px;
        background:radial-gradient(ellipse at right center,rgba(253,181,21,.07) 0%,transparent 70%);
        pointer-events:none;
    }

    /* stagger cards */
    .packages-grid .pkg-card:nth-child(1){animation-delay:.04s}
    .packages-grid .pkg-card:nth-child(2){animation-delay:.08s}
    .packages-grid .pkg-card:nth-child(3){animation-delay:.12s}
    .packages-grid .pkg-card:nth-child(4){animation-delay:.16s}
    .packages-grid .pkg-card:nth-child(5){animation-delay:.20s}
    .packages-grid .pkg-card:nth-child(6){animation-delay:.24s}
    .packages-grid .pkg-card:nth-child(7){animation-delay:.28s}
    .packages-grid .pkg-card:nth-child(8){animation-delay:.32s}
</style>
@endpush

@section('content')

@php
$packageDetails = [
    'free-trial'  => ['stars'=>1,  'perday'=>null,    'excludes'=>'2–10★ Picks'],
    '1-week'      => ['stars'=>2,  'perday'=>3.57,    'excludes'=>'3–10★ Picks'],
    '2-weeks'     => ['stars'=>3,  'perday'=>3.57,    'excludes'=>'4–10★ Picks'],
    'monthly'     => ['stars'=>4,  'perday'=>3.33,    'excludes'=>'5, 10★ Picks'],
    '2-months'    => ['stars'=>4,  'perday'=>2.50,    'excludes'=>'5, 10★ Picks'],
    'quarterly'   => ['stars'=>5,  'perday'=>2.22,    'excludes'=>'10★ Picks'],
    'semi-annual' => ['stars'=>5,  'perday'=>1.67,    'excludes'=>'10★ Picks'],
    '9-months'    => ['stars'=>7,  'perday'=>1.48,    'excludes'=>'10★ Picks'],
    '12-months'   => ['stars'=>10, 'perday'=>1.37,    'excludes'=>null],
];
$freeTrial  = $featuredPackages->firstWhere('slug','free-trial');
$paidPkgs   = $featuredPackages->filter(fn($p) => $p->slug !== 'free-trial');
$whale      = $whaleRegular ?? $whalePackages->first();
@endphp

{{-- Expired notice --}}
@if(session('expired'))
<div class="notice-expired">
    <div style="font-size:1.5rem;flex-shrink:0;">🔒</div>
    <div>
        <div style="font-size:14px;font-weight:700;color:#fff;margin-bottom:3px;">Your Access Has Expired</div>
        <div style="font-size:12.5px;color:rgba(255,255,255,.45);line-height:1.6;">Choose a package below to continue viewing expert picks and analysis.</div>
    </div>
</div>
@endif

{{-- Current plan --}}
@if($currentSub)
<div class="notice-plan">
    <svg width="17" height="17" fill="none" stroke="#FDB515" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    <span style="font-size:13px;color:#FFFCEE;font-weight:600;">Current plan:</span>
    <span style="font-size:13px;color:#FDB515;font-weight:700;">{{ $currentSub->packageName() }}</span>
    <span style="font-size:13px;color:#6e6e6e;">· {{ $currentSub->max_stars }}★ access</span>
    @if(!$currentSub->isExpired())
    <span style="font-size:13px;color:#4a4a4a;">· Expires {{ $currentSub->expires_at->format('M d, Y') }}</span>
    @endif
</div>
@endif

{{-- ── Free Trial ── --}}
@if($freeTrial)
<div class="section-divider">Free Trial</div>
<div class="trial-banner">
    <div style="position:relative;z-index:1;">
        <div class="trial-badge">
            <svg width="9" height="9" fill="#4ade80" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Starts Free
        </div>
        <div class="trial-title">Free Trial</div>
        <div class="trial-sub">7 days · No credit card required · 1★ picks included</div>
        <div class="trial-features">
            @foreach(['Full 7-day access','All Sport Picks','Simulation Model Access','Daily Consensus Data'] as $f)
            <div class="trial-feat">
                <svg width="13" height="13" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="rgba(74,222,128,.1)"/><polyline points="5,8.5 7,10.5 11,6" stroke="#4ade80" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                {{ $f }}
            </div>
            @endforeach
        </div>
    </div>
    <div style="flex-shrink:0;position:relative;z-index:1;text-align:center;">
        <div style="font-family:'Clash Display',sans-serif;font-size:2.8rem;font-weight:700;color:#FFFCEE;line-height:1;margin-bottom:6px;">FREE</div>
        @php $isCurTrial = $currentSub && $currentSub->package && $currentSub->package->slug === 'free-trial'; @endphp
        @if($isCurTrial)
        <div style="padding:10px 28px;border-radius:8px;font-size:13px;font-weight:700;background:rgba(253,181,21,.08);border:1.5px solid rgba(253,181,21,.2);color:#FDB515;display:inline-block;">✓ Active Plan</div>
        @elseif($hasUsedTrial)
        <div style="padding:10px 28px;border-radius:8px;font-size:13px;font-weight:600;background:rgba(255,255,255,.02);border:1.5px solid rgba(255,255,255,.06);color:#3a3a3a;display:inline-flex;align-items:center;gap:6px;">
            <svg width="13" height="13" fill="none" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" stroke="#3a3a3a" stroke-width="2"/><path stroke="#3a3a3a" stroke-width="2" stroke-linecap="round" d="M7 11V7a5 5 0 0110 0v4"/></svg>
            Trial Already Used
        </div>
        @else
        <button onclick="showUpgradeModal('Free Trial','free')" style="padding:11px 32px;border-radius:9px;font-size:13.5px;font-weight:700;cursor:pointer;border:1.5px solid #22c55e;color:#22c55e;background:transparent;transition:background .15s;font-family:'DM Sans',sans-serif;" onmouseover="this.style.background='rgba(34,197,94,.08)'" onmouseout="this.style.background='transparent'">
            Start Free Trial →
        </button>
        @endif
    </div>
</div>
@endif

{{-- ── Paid Packages ── --}}
<div class="section-divider">Paid Packages — One-Time, No Recurring Billing</div>

<div class="packages-grid">
    @foreach($paidPkgs as $pkg)
    @php
        $details   = $packageDetails[$pkg->slug] ?? ['stars'=>4,'perday'=>null,'excludes'=>null];
        $isCurrent = $currentSub && $currentSub->package && $currentSub->package->slug === $pkg->slug;
        $isPopular = $pkg->slug === 'monthly';
        $isBest    = $pkg->slug === '12-months';
        $isValue   = $pkg->slug === 'semi-annual';
    @endphp
    <div class="pkg-card {{ $isCurrent ? 'is-current' : '' }}">

        @if($isCurrent)
        <div class="card-top-badge" style="background:#FDB515;color:#171818;">CURRENT PLAN</div>
        @endif

        <div class="card-badge-row">
            @if($isPopular)
            <span class="card-badge badge-gold">⭐ Most Popular</span>
            @elseif($isBest)
            <span class="card-badge badge-teal">🏆 Best Value</span>
            @elseif($isValue)
            <span class="card-badge" style="background:rgba(139,92,246,.1);color:#a78bfa;border:1px solid rgba(139,92,246,.22);">💎 Great Deal</span>
            @endif
        </div>

        <div class="card-duration">{{ $pkg->duration }} Access</div>
        <div class="card-name">{{ $pkg->name }}</div>

        <div class="card-price">
            <sup>$</sup>{{ number_format($pkg->price, 2) }}
        </div>
        <div class="card-perday">
            @if($details['perday']) ~${{ number_format($details['perday'],2) }} / day @else &nbsp; @endif
        </div>

        <div class="card-tier">
            <span class="card-tier-label">Picks Access</span>
            <span class="card-tier-val">1★ – {{ $details['stars'] }}★ Picks</span>
        </div>

        @if($isCurrent)
        <div class="card-cta cta-current">✓ Active Plan</div>
        @else
        <a href="{{ route('cashier', ['package' => $pkg->slug]) }}" class="card-cta {{ $isPopular ? 'cta-solid' : 'cta-outline' }}">
            Get Started →
        </a>
        @endif
    </div>
    @endforeach
</div>

{{-- ── Whale Package ── --}}
@if($whale)
<div class="section-divider">Ultimate Access</div>
<div class="whale-card">
    <div style="display:flex;align-items:center;gap:18px;position:relative;z-index:1;">
        <div style="font-size:2.8rem;filter:drop-shadow(0 2px 10px rgba(253,181,21,.35));flex-shrink:0;">🐋</div>
        <div>
            <div style="font-size:9px;color:#FDB515;font-weight:800;text-transform:uppercase;letter-spacing:1px;margin-bottom:5px;">All-Access · 1★ – 10★ Picks</div>
            <div style="font-family:'Clash Display',sans-serif;font-size:1.35rem;font-weight:700;color:#FFFCEE;margin-bottom:8px;">{{ $whale->name ?? 'Whale Package' }}</div>
            <div style="display:flex;gap:18px;flex-wrap:wrap;">
                @foreach(['All star picks (1★ – 10★)','1 Year Access','Priority Support'] as $f)
                <span style="display:flex;align-items:center;gap:5px;font-size:12px;color:#6e6e6e;">
                    <svg width="12" height="12" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="rgba(253,181,21,.08)"/><polyline points="5,8.5 7,10.5 11,6" stroke="#FDB515" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                    {{ $f }}
                </span>
                @endforeach
            </div>
        </div>
    </div>
    <div style="flex-shrink:0;text-align:center;position:relative;z-index:1;">
        <div style="font-family:'Clash Display',sans-serif;font-size:2.2rem;font-weight:700;background:linear-gradient(135deg,#fdd060,#FDB515,#e09c0d);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;line-height:1;">${{ number_format($whale->price,2) }}</div>
        <div style="font-size:10.5px;color:#4a4a4a;margin:4px 0 14px;">One-time · 1 Year Access</div>
        <a href="{{ route('cashier', ['package' => 'whale-package']) }}"
           style="display:inline-flex;align-items:center;gap:8px;padding:12px 28px;background:#FDB515;color:#171818;border-radius:50px;font-weight:700;font-size:13.5px;text-decoration:none;box-shadow:0 0 20px rgba(253,181,21,.28);transition:box-shadow .2s,transform .2s;"
           onmouseover="this.style.boxShadow='0 0 32px rgba(253,181,21,.5)';this.style.transform='translateY(-1px)'"
           onmouseout="this.style.boxShadow='0 0 20px rgba(253,181,21,.28)';this.style.transform='none'">
            🐋 Become a Whale
        </a>
    </div>
</div>
@endif

<p style="text-align:center;color:#3a3a3a;font-size:11.5px;margin-top:18px;line-height:1.6;">
    All packages are one-time charges — no auto-renewal, ever. &nbsp;·&nbsp;
    Questions? <a href="mailto:help@inspin.com" style="color:#FDB515;text-decoration:none;">help@inspin.com</a>
</p>

{{-- Free Trial Modal --}}
<div id="upgradeModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.8);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(8px);">
    <div style="background:#1a1a1a;border:1px solid rgba(74,222,128,.2);border-radius:16px;padding:30px;max-width:380px;width:92%;text-align:center;box-shadow:0 24px 60px rgba(0,0,0,.7);">
        <div style="font-size:2.2rem;margin-bottom:12px;">🎁</div>
        <h3 style="font-family:'Clash Display',sans-serif;font-size:1.15rem;font-weight:700;color:#FFFCEE;margin-bottom:8px;">Start Your Free Trial</h3>
        <p style="font-size:13px;color:#6e6e6e;margin-bottom:20px;line-height:1.65;">Contact our support team to activate your 7-day free trial. No payment required.</p>
        <div style="display:flex;gap:10px;justify-content:center;">
            <button onclick="document.getElementById('upgradeModal').style.display='none'"
                style="padding:10px 22px;background:#212121;border:1px solid rgba(255,255,255,.1);color:#9a9a9a;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;"
                onmouseover="this.style.color='#FFFCEE'" onmouseout="this.style.color='#9a9a9a'">
                Cancel
            </button>
            <a href="/profile" onclick="document.getElementById('upgradeModal').style.display='none'"
                style="padding:10px 22px;background:#22c55e;color:#fff;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                Contact Support →
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showUpgradeModal(pkgName, type) {
    document.getElementById('upgradeModal').style.display = 'flex';
}
document.getElementById('upgradeModal').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
@endpush
@endsection
