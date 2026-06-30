@extends('layouts.subscriber')
@section('title', 'Membership Packages - INSPIN')
@section('page-title', 'Membership Packages')

@push('styles')
<style>
    @keyframes fadeUp  { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }
    @keyframes whaleBob {
        0%,100% { transform: translateY(0) rotate(-3deg); }
        50%      { transform: translateY(-6px) rotate(3deg); }
    }
    @keyframes whaleGlow {
        0%,100% { box-shadow: 0 0 0 0 rgba(253,181,21,0), 0 8px 28px rgba(0,0,0,.5); }
        50%     { box-shadow: 0 0 28px 6px rgba(253,181,21,.18), 0 8px 28px rgba(0,0,0,.5); }
    }
    @keyframes shimmer {
        0%   { background-position: -300% center; }
        100% { background-position: 300% center; }
    }
    @keyframes borderPulse {
        0%,100% { border-color: rgba(253,181,21,.35); }
        50%     { border-color: rgba(253,181,21,.75); }
    }

    /* ── Notices ── */
    .notice-expired {
        display:flex; align-items:flex-start; gap:14px;
        background:rgba(239,68,68,.07); border:1px solid rgba(239,68,68,.2);
        border-radius:12px; padding:18px 22px; margin-bottom:24px;
        animation:fadeUp .4s ease both;
    }
    .notice-plan {
        display:flex; align-items:center; gap:10px; flex-wrap:wrap;
        background:rgba(253,181,21,.05); border:1px solid rgba(253,181,21,.15);
        border-radius:12px; padding:13px 20px; margin-bottom:24px;
        animation:fadeUp .4s ease both;
    }

    /* ── Section divider ── */
    .pkg-divider {
        display:flex; align-items:center; gap:12px;
        font-size:10px; color:#3a3a3a; text-transform:uppercase;
        letter-spacing:.7px; font-weight:700; margin:26px 0 16px;
    }
    .pkg-divider::before,.pkg-divider::after { content:''; flex:1; height:1px; background:rgba(255,252,238,.05); }

    /* ── Free trial banner ── */
    .trial-banner {
        display:flex; align-items:center; justify-content:space-between; gap:20px;
        background:#141414; border:1.5px solid rgba(74,222,128,.2);
        border-radius:16px; padding:20px 26px; margin-bottom:6px;
        position:relative; overflow:hidden; flex-wrap:wrap;
        animation:fadeUp .4s ease .05s both;
    }
    .trial-banner::after {
        content:''; position:absolute; right:0; top:0; bottom:0; width:260px;
        background:radial-gradient(ellipse at right center,rgba(74,222,128,.06) 0%,transparent 70%);
        pointer-events:none;
    }
    .trial-badge {
        display:inline-flex; align-items:center; gap:5px;
        font-size:9px; font-weight:800; text-transform:uppercase; letter-spacing:.5px;
        background:rgba(74,222,128,.1); color:#4ade80;
        border:1px solid rgba(74,222,128,.25); border-radius:20px; padding:3px 10px; margin-bottom:8px;
    }
    .trial-feats { display:flex; gap:14px; flex-wrap:wrap; margin-top:10px; }
    .trial-feat  { display:flex; align-items:center; gap:5px; font-size:12px; color:#6e6e6e; }

    /* ── Package grid ── */
    .packages-grid {
        display:grid;
        grid-template-columns:repeat(4,1fr);
        gap:12px;
        margin-bottom:6px;
        align-items:stretch;
    }
    @media(max-width:1060px){ .packages-grid { grid-template-columns:repeat(3,1fr); } }
    @media(max-width:740px) { .packages-grid { grid-template-columns:repeat(2,1fr); } }
    @media(max-width:440px) { .packages-grid { grid-template-columns:1fr; } }

    /* ── Regular package card ── */
    .pkg-card {
        background:#141414; border:1.5px solid rgba(255,252,238,.07);
        border-radius:14px; padding:18px 16px 16px;
        position:relative; display:flex; flex-direction:column;
        transition:border-color .2s, box-shadow .2s, transform .18s;
        animation:fadeUp .4s ease both;
    }
    .pkg-card:hover { border-color:rgba(253,181,21,.3); transform:translateY(-2px); box-shadow:0 8px 22px rgba(0,0,0,.45); }
    .pkg-card.is-current { border-color:rgba(253,181,21,.35); background:rgba(253,181,21,.02); }

    /* stagger */
    .pkg-card:nth-child(1){animation-delay:.04s} .pkg-card:nth-child(2){animation-delay:.08s}
    .pkg-card:nth-child(3){animation-delay:.12s} .pkg-card:nth-child(4){animation-delay:.16s}
    .pkg-card:nth-child(5){animation-delay:.20s} .pkg-card:nth-child(6){animation-delay:.24s}
    .pkg-card:nth-child(7){animation-delay:.28s} .pkg-card:nth-child(8){animation-delay:.32s}

    .card-top-badge {
        position:absolute; top:-10px; left:50%; transform:translateX(-50%);
        font-size:8.5px; font-weight:800; text-transform:uppercase; letter-spacing:.5px;
        padding:3px 12px; border-radius:20px; white-space:nowrap;
    }
    .card-badge-row { height:22px; margin-bottom:10px; display:flex; align-items:center; }
    .card-badge {
        display:inline-flex; align-items:center; gap:4px;
        font-size:8.5px; font-weight:800; text-transform:uppercase; letter-spacing:.5px;
        border-radius:20px; padding:2px 9px; line-height:1; white-space:nowrap;
    }
    .badge-gold  { background:rgba(253,181,21,.1); color:#FDB515; border:1px solid rgba(253,181,21,.22); }
    .badge-teal  { background:rgba(45,212,191,.1);  color:#2dd4bf; border:1px solid rgba(45,212,191,.22); }
    .badge-purple{ background:rgba(139,92,246,.1);  color:#a78bfa; border:1px solid rgba(139,92,246,.22); }

    .card-duration { font-size:10px; color:#555; letter-spacing:.3px; margin-bottom:4px; }
    .card-name     { font-size:15px; font-weight:700; color:#FFFCEE; margin-bottom:14px; }
    .card-price    { font-family:'Clash Display',sans-serif; font-size:27px; font-weight:700; color:#FDB515; line-height:1; margin-bottom:2px; }
    .card-price sup{ font-size:13px; color:#777; vertical-align:top; margin-top:5px; font-family:'DM Sans',sans-serif; font-weight:400; }
    .card-perday   { font-size:10.5px; color:#3a3a3a; margin-bottom:14px; }

    .card-tier {
        background:rgba(253,181,21,.04); border:1px solid rgba(253,181,21,.1);
        border-radius:8px; padding:7px 10px; text-align:center; margin-bottom:14px;
    }
    .card-tier-label { font-size:8.5px; color:#4a4a4a; text-transform:uppercase; letter-spacing:.4px; display:block; margin-bottom:2px; }
    .card-tier-val   { font-size:12.5px; color:#FDB515; font-weight:700; }

    .card-cta {
        display:flex; align-items:center; justify-content:center;
        width:100%; padding:10px 12px; border-radius:9px;
        font-size:13px; font-weight:700; cursor:pointer; text-decoration:none;
        font-family:'DM Sans',sans-serif; margin-top:auto; transition:background .15s, box-shadow .15s;
    }
    .cta-outline { border:1.5px solid #FDB515; color:#FDB515; background:transparent; }
    .cta-outline:hover { background:rgba(253,181,21,.08); box-shadow:0 0 14px rgba(253,181,21,.15); }
    .cta-solid   { border:1.5px solid #FDB515; background:#FDB515; color:#171818; }
    .cta-solid:hover { background:#e09c0d; border-color:#e09c0d; }
    .cta-current { border:1.5px solid rgba(253,181,21,.2); background:rgba(253,181,21,.07); color:#FDB515; cursor:default; }
    .cta-trial   { border:1.5px solid #22c55e; color:#22c55e; background:transparent; }
    .cta-trial:hover { background:rgba(34,197,94,.08); }
    .cta-locked  { border:1.5px solid rgba(255,255,255,.06); background:rgba(255,255,255,.02); color:#3a3a3a; cursor:not-allowed; }

    /* ── WHALE card — same grid size, special effects ── */
    .whale-card {
        background: radial-gradient(ellipse at 30% 20%, rgba(253,181,21,.07) 0%, #141414 60%);
        border:2px solid rgba(253,181,21,.4);
        border-radius:14px; padding:18px 16px 16px;
        position:relative; display:flex; flex-direction:column;
        overflow:hidden;
        animation:fadeUp .4s ease .36s both, whaleGlow 3s ease-in-out 1s infinite, borderPulse 3s ease-in-out 1s infinite;
    }
    /* shimmer sweep */
    .whale-card::before {
        content:'';
        position:absolute; inset:0;
        background: linear-gradient(105deg, transparent 40%, rgba(253,181,21,.07) 50%, transparent 60%);
        background-size:300% 100%;
        animation: shimmer 4s linear 1.5s infinite;
        pointer-events:none;
    }
    /* corner sparkle */
    .whale-card::after {
        content:'✦';
        position:absolute; top:10px; left:12px;
        font-size:10px; color:rgba(253,181,21,.35);
        animation: whaleBob 3s ease-in-out infinite;
    }
    .whale-emoji {
        font-size:2rem; line-height:1; margin-bottom:6px; display:block;
        animation: whaleBob 2.8s ease-in-out infinite;
        filter:drop-shadow(0 2px 8px rgba(253,181,21,.4));
    }
    .whale-ultimate-badge {
        display:inline-flex; align-items:center; gap:4px;
        font-size:8.5px; font-weight:800; text-transform:uppercase; letter-spacing:.6px;
        background:rgba(253,181,21,.12); color:#FDB515;
        border:1px solid rgba(253,181,21,.3); border-radius:20px; padding:2px 9px;
        margin-bottom:10px;
    }
    .whale-name { font-size:15px; font-weight:700; color:#FFFCEE; margin-bottom:14px; }
    .whale-price {
        font-family:'Clash Display',sans-serif; font-size:27px; font-weight:700; line-height:1;
        background:linear-gradient(135deg,#fdd060,#FDB515,#e09c0d);
        -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
        margin-bottom:2px;
    }
    .whale-perday { font-size:10.5px; color:#3a3a3a; margin-bottom:14px; }
    .whale-tier {
        background:rgba(253,181,21,.06); border:1px solid rgba(253,181,21,.18);
        border-radius:8px; padding:7px 10px; text-align:center; margin-bottom:14px;
    }
    .whale-tier-val { font-size:13px; color:#FDB515; font-weight:700; }
    .whale-cta {
        display:flex; align-items:center; justify-content:center; gap:6px;
        width:100%; padding:11px 12px; border-radius:9px;
        font-size:13px; font-weight:700; cursor:pointer; text-decoration:none;
        font-family:'DM Sans',sans-serif; margin-top:auto;
        background:#FDB515; color:#171818; border:none;
        box-shadow:0 0 18px rgba(253,181,21,.3);
        transition:background .15s, box-shadow .2s, transform .15s;
        position:relative; z-index:1;
    }
    .whale-cta:hover { background:#e09c0d; box-shadow:0 0 28px rgba(253,181,21,.5); transform:translateY(-1px); }
</style>
@endpush

@section('content')

@php
$starsMap = ['1-week'=>2,'2-weeks'=>3,'monthly'=>4,'2-months'=>4,'quarterly'=>5,'semi-annual'=>5,'9-months'=>7,'12-months'=>10,'whale-package'=>10];
$perDayMap= ['1-week'=>3.57,'2-weeks'=>3.57,'monthly'=>3.33,'2-months'=>2.50,'quarterly'=>2.22,'semi-annual'=>1.67,'9-months'=>1.48,'12-months'=>1.37,'whale-package'=>2.74];
@endphp

{{-- Expired --}}
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
    <svg width="16" height="16" fill="none" stroke="#FDB515" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
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
@php $isCurTrial = $currentSub && $currentSub->package && $currentSub->package->slug === 'free-trial'; @endphp
<div class="pkg-divider">Free Trial</div>
<div class="trial-banner">
    <div style="position:relative;z-index:1;">
        <div class="trial-badge">
            <svg width="9" height="9" fill="#4ade80" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            Starts Free
        </div>
        <div style="font-family:'Clash Display',sans-serif;font-size:1.55rem;font-weight:700;color:#FFFCEE;line-height:1;margin-bottom:4px;">Free Trial</div>
        <div style="font-size:12px;color:#555;">7 days · No credit card required · 1★ picks included</div>
        <div class="trial-feats">
            @foreach(['Full 7-day access','All Sport Picks','Simulation Model','Daily Consensus Data'] as $f)
            <div class="trial-feat">
                <svg width="12" height="12" viewBox="0 0 16 16" fill="none"><circle cx="8" cy="8" r="8" fill="rgba(74,222,128,.1)"/><polyline points="5,8.5 7,10.5 11,6" stroke="#4ade80" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                {{ $f }}
            </div>
            @endforeach
        </div>
    </div>
    <div style="flex-shrink:0;text-align:center;position:relative;z-index:1;">
        <div style="font-family:'Clash Display',sans-serif;font-size:2.6rem;font-weight:700;color:#FFFCEE;line-height:1;margin-bottom:10px;">FREE</div>
        @if($isCurTrial)
        <div style="padding:10px 28px;border-radius:8px;font-size:13px;font-weight:700;background:rgba(253,181,21,.08);border:1.5px solid rgba(253,181,21,.2);color:#FDB515;display:inline-block;">✓ Active Plan</div>
        @elseif($hasUsedTrial)
        <div style="padding:10px 24px;border-radius:8px;font-size:13px;font-weight:600;background:rgba(255,255,255,.02);border:1.5px solid rgba(255,255,255,.06);color:#3a3a3a;display:inline-flex;align-items:center;gap:6px;">
            <svg width="12" height="12" fill="none" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" stroke="#3a3a3a" stroke-width="2"/><path stroke="#3a3a3a" stroke-width="2" stroke-linecap="round" d="M7 11V7a5 5 0 0110 0v4"/></svg>
            Trial Already Used
        </div>
        @else
        <button onclick="showUpgradeModal()" style="padding:11px 32px;border-radius:9px;font-size:13.5px;font-weight:700;cursor:pointer;border:1.5px solid #22c55e;color:#22c55e;background:transparent;transition:background .15s;font-family:'DM Sans',sans-serif;" onmouseover="this.style.background='rgba(34,197,94,.08)'" onmouseout="this.style.background='transparent'">
            Start Free Trial →
        </button>
        @endif
    </div>
</div>
@endif

{{-- ── Paid Packages + Whale in one grid ── --}}
<div class="pkg-divider">Paid Packages — One-Time · No Recurring Billing</div>
<div class="packages-grid">

    @foreach($paidPackages as $pkg)
    @php
        $stars     = $starsMap[$pkg->slug] ?? 4;
        $perDay    = $perDayMap[$pkg->slug] ?? null;
        $isCurrent = $currentSub && $currentSub->package && $currentSub->package->slug === $pkg->slug;
        $isPopular = $pkg->slug === 'monthly';
        $isBestVal = $pkg->price >= 499; // 12 months tier
        $isGreat   = $pkg->slug === 'semi-annual';
    @endphp
    <div class="pkg-card {{ $isCurrent ? 'is-current' : '' }}">
        @if($isCurrent)
        <div class="card-top-badge" style="background:#FDB515;color:#171818;">CURRENT PLAN</div>
        @endif
        <div class="card-badge-row">
            @if($isPopular)    <span class="card-badge badge-gold">⭐ Most Popular</span>
            @elseif($isBestVal)<span class="card-badge badge-teal">🏆 Best Value</span>
            @elseif($isGreat)  <span class="card-badge badge-purple">💎 Great Deal</span>
            @endif
        </div>
        <div class="card-duration">{{ $pkg->duration }} Access</div>
        <div class="card-name">{{ $pkg->name }}</div>
        <div class="card-price"><sup>$</sup>{{ number_format($pkg->price, 2) }}</div>
        <div class="card-perday">@if($perDay)~${{ number_format($perDay,2) }} / day@else &nbsp;@endif</div>
        <div class="card-tier">
            <span class="card-tier-label">Picks Access</span>
            <span class="card-tier-val">1★ – {{ $stars }}★ Picks</span>
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

    {{-- Whale Card — same grid slot, special treatment --}}
    @if($whale)
    @php $whaleIsCurrent = $currentSub && $currentSub->package && $currentSub->package->slug === 'whale-package'; @endphp
    <div class="whale-card">
        <span class="whale-emoji">🐋</span>
        <div class="whale-ultimate-badge">🌊 Ultimate Access</div>
        <div class="whale-name">{{ $whale->name }}</div>
        <div class="whale-price"><sup style="font-size:13px;font-weight:400;font-family:'DM Sans',sans-serif;-webkit-text-fill-color:#9a9a9a;background:none;">$</sup>{{ number_format($whale->price, 2) }}</div>
        <div class="whale-perday">~${{ number_format($perDayMap['whale-package'],2) }} / day</div>
        <div class="whale-tier">
            <span class="card-tier-label">Picks Access</span>
            <span class="whale-tier-val">1★ – 10★ All Picks</span>
        </div>
        @if($whaleIsCurrent)
        <div class="card-cta cta-current">✓ Active Plan</div>
        @else
        <a href="{{ route('cashier', ['package' => 'whale-package']) }}" class="whale-cta">
            🐋 Become a Whale
        </a>
        @endif
    </div>
    @endif

</div>

<p style="text-align:center;color:#3a3a3a;font-size:11.5px;margin-top:14px;line-height:1.6;">
    All packages are one-time charges — no auto-renewal, ever. &nbsp;·&nbsp;
    Questions? <a href="mailto:help@inspin.com" style="color:#FDB515;text-decoration:none;">help@inspin.com</a>
</p>

{{-- Free Trial Modal --}}
<div id="upgradeModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.8);z-index:9999;align-items:center;justify-content:center;backdrop-filter:blur(8px);">
    <div style="background:#1a1a1a;border:1px solid rgba(74,222,128,.2);border-radius:16px;padding:30px;max-width:370px;width:92%;text-align:center;box-shadow:0 24px 60px rgba(0,0,0,.7);">
        <div style="font-size:2rem;margin-bottom:12px;">🎁</div>
        <h3 style="font-family:'Clash Display',sans-serif;font-size:1.1rem;font-weight:700;color:#FFFCEE;margin-bottom:8px;">Start Your Free Trial</h3>
        <p style="font-size:13px;color:#6e6e6e;margin-bottom:20px;line-height:1.65;">Contact our support team to activate your 7-day free trial. No payment required.</p>
        <div style="display:flex;gap:10px;justify-content:center;">
            <button onclick="document.getElementById('upgradeModal').style.display='none'"
                style="padding:10px 20px;background:#212121;border:1px solid rgba(255,255,255,.1);color:#9a9a9a;border-radius:8px;font-size:13px;font-weight:600;cursor:pointer;font-family:'DM Sans',sans-serif;"
                onmouseover="this.style.color='#FFFCEE'" onmouseout="this.style.color='#9a9a9a'">
                Cancel
            </button>
            <a href="/profile" onclick="document.getElementById('upgradeModal').style.display='none'"
                style="padding:10px 20px;background:#22c55e;color:#fff;border-radius:8px;font-size:13px;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                Contact Support →
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showUpgradeModal() { document.getElementById('upgradeModal').style.display = 'flex'; }
document.getElementById('upgradeModal').addEventListener('click', function(e) {
    if (e.target === this) this.style.display = 'none';
});
</script>
@endpush
@endsection
