@extends('layouts.public')
@section('title', 'Join INSPIN - Membership Packages')

@push('styles')
<style>
    .pkg-grid { grid-template-columns: repeat(3, 1fr); }
    @media (max-width: 900px) { .pkg-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px) { .pkg-grid { grid-template-columns: 1fr; } }
    @media (max-width: 560px) {
        .whale-inner { flex-direction: column !important; text-align: center !important; }
        .whale-inner > div:first-child { justify-content: center !important; }
        .whale-price-block { width: 100% !important; }
    }
</style>
@endpush

@section('content')

{{-- Hero --}}
<div style="background:radial-gradient(ellipse at 50% -20%,#1c1917 0%,#09090b 55%);padding:52px 0 44px;text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background:url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23f59e0b\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');pointer-events:none;"></div>
    <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,#d97706 20%,#f59e0b 50%,#d97706 80%,transparent);"></div>
    <div class="container" style="position:relative;">
        <h1 style="color:#fafafa;font-size:2rem;font-weight:900;margin-bottom:10px;letter-spacing:-0.3px;">Membership Packages</h1>
        <p style="color:#71717a;max-width:560px;margin:0 auto 8px;font-size:15px;">Start free. Upgrade anytime. Cancel anytime.</p>
        <p style="color:#a1a1aa;max-width:620px;margin:0 auto;font-size:14px;">Our simulation model is up <strong style="color:#f59e0b;">+150 units</strong> over 3 years — a $100 bettor netted $15,000+ profit.</p>
    </div>
</div>

{{-- Packages Grid --}}
<div class="section section-alt">
    <div class="container">

        @php
            $featuredSlugs = ['free-trial', '1-week', '2-weeks', 'monthly', 'quarterly', 'semi-annual'];
            $featuredPackages = $packages->filter(fn($p) => in_array($p->slug, $featuredSlugs))->sortBy(fn($p) => array_search($p->slug, $featuredSlugs));
            $whaleRegular = $packages->firstWhere('slug', 'whale-package');
        @endphp

        <div class="pkg-grid" style="display:grid;gap:20px;margin-bottom:32px;">
            @foreach($featuredPackages as $pkg)
            @php
                $isPopular = $pkg->slug === 'monthly';
                $isBest    = $pkg->slug === 'semi-annual';
                $isFree    = $pkg->slug === 'free-trial';
                $hasBadge  = $isPopular || $isBest || $isFree;
            @endphp
            <div style="background:#fff;border-radius:16px;padding:28px 24px;text-align:center;position:relative;border:1.5px solid {{ $isPopular ? '#09090b' : '#e4e4e7' }};box-shadow:{{ $isPopular ? '0 12px 40px rgba(0,0,0,0.14),0 0 0 1px rgba(245,158,11,0.08)' : '0 2px 10px rgba(0,0,0,0.05)' }};display:flex;flex-direction:column;transition:all 0.25s;">
                @if($isPopular)
                <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,#09090b,#18181b);color:#f59e0b;padding:4px 18px;border-radius:20px;font-size:10.5px;font-weight:700;letter-spacing:0.6px;white-space:nowrap;box-shadow:0 2px 8px rgba(0,0,0,0.25);">MOST POPULAR</div>
                @elseif($isBest)
                <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,#09090b,#18181b);color:#f59e0b;padding:4px 18px;border-radius:20px;font-size:10.5px;font-weight:700;letter-spacing:0.6px;white-space:nowrap;box-shadow:0 2px 8px rgba(0,0,0,0.25);">BEST VALUE</div>
                @elseif($isFree)
                <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,#22c55e,#16a34a);color:#fff;padding:4px 18px;border-radius:20px;font-size:10.5px;font-weight:700;letter-spacing:0.6px;white-space:nowrap;box-shadow:0 2px 8px rgba(34,197,94,0.3);">START FREE</div>
                @endif

                <div style="font-size:1rem;font-weight:800;color:#09090b;margin-bottom:4px;margin-top:{{ $hasBadge ? '8px' : '0' }};letter-spacing:-0.1px;">{{ $pkg->name }}</div>
                <div style="color:#71717a;font-size:12px;margin-bottom:20px;letter-spacing:0.2px;">{{ $pkg->duration }} Access</div>

                <div style="margin-bottom:20px;">
                    @if($isFree)
                    <div style="font-size:2.8rem;font-weight:900;color:#09090b;line-height:1;letter-spacing:-1px;">FREE</div>
                    <div style="font-size:12px;color:#71717a;margin-top:6px;">No credit card needed</div>
                    @else
                    <div style="font-size:2.4rem;font-weight:900;color:#09090b;line-height:1;letter-spacing:-1px;"><sup style="font-size:1rem;color:#a1a1aa;vertical-align:top;margin-top:8px;font-weight:600;">$</sup>{{ number_format($pkg->price, 2) }}</div>
                    @endif
                </div>

                <ul style="list-style:none;text-align:left;margin:0 0 24px;padding:0;flex:1;">
                    @foreach(array_slice($pkg->features ?? [], 0, 5) as $feature)
                    <li style="padding:7px 0;font-size:13px;color:#52525b;border-bottom:1px solid #f4f4f5;display:flex;align-items:center;gap:8px;">
                        <span style="color:#f59e0b;font-weight:700;flex-shrink:0;font-size:12px;">✓</span>{{ $feature }}
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('register') }}" style="display:block;width:100%;padding:12px;border-radius:10px;font-weight:700;font-size:14px;text-decoration:none;text-align:center;background:{{ $isPopular ? 'linear-gradient(135deg,#09090b,#18181b)' : ($isFree ? 'linear-gradient(135deg,#22c55e,#16a34a)' : 'linear-gradient(135deg,#1e3a5f,#0f2340)') }};color:{{ $isPopular ? '#f59e0b' : '#fff' }};box-shadow:{{ $isPopular ? '0 4px 14px rgba(0,0,0,0.2)' : '0 2px 8px rgba(0,0,0,0.1)' }};letter-spacing:0.1px;">
                    {{ $isFree ? 'Start Free Trial' : 'Get Started' }}
                </a>
            </div>
            @endforeach
        </div>

        {{-- Whale Banner --}}
        @php $whalePkg = $whaleRegular ?? $whalePackages->first(); @endphp
        @if($whalePkg)
        <a href="{{ route('register') }}" style="display:block;text-decoration:none;background:linear-gradient(135deg,#09090b 0%,#1c1917 50%,#09090b 100%);border-radius:18px;padding:36px 40px;position:relative;overflow:hidden;border:1px solid #27272a;box-shadow:0 8px 40px rgba(0,0,0,0.3),0 0 0 1px rgba(245,158,11,0.1);">
            <div style="position:absolute;top:0;right:0;width:300px;height:100%;background:radial-gradient(ellipse at 80% 50%,rgba(245,158,11,0.12) 0%,transparent 65%);pointer-events:none;"></div>
            <div style="position:absolute;top:-60px;right:60px;width:160px;height:160px;background:radial-gradient(circle,rgba(245,158,11,0.08) 0%,transparent 70%);pointer-events:none;"></div>
            <div style="position:absolute;bottom:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(245,158,11,0.3),transparent);pointer-events:none;"></div>
            <div class="whale-inner" style="display:flex;align-items:center;justify-content:space-between;gap:24px;position:relative;z-index:1;flex-wrap:wrap;">
                <div style="display:flex;align-items:center;gap:20px;">
                    <div style="font-size:3.2rem;line-height:1;filter:drop-shadow(0 4px 12px rgba(245,158,11,0.3));">🐋</div>
                    <div>
                        <div style="color:#f59e0b;font-size:10.5px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;margin-bottom:6px;">Premium Access</div>
                        <div style="color:#fafafa;font-size:1.5rem;font-weight:900;margin-bottom:8px;letter-spacing:-0.3px;">{{ $whalePkg->name ?? $whalePkg->title ?? 'Whale Package' }}</div>
                        <div style="display:flex;gap:16px;flex-wrap:wrap;">
                            @foreach(array_slice(($whalePkg->features ?? []), 0, 4) as $feat)
                            <span style="color:#71717a;font-size:13px;display:flex;align-items:center;gap:5px;"><span style="color:#f59e0b;font-size:10px;">★</span>{{ $feat }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="whale-price-block" style="text-align:center;flex-shrink:0;">
                    <div style="background:linear-gradient(135deg,#fcd34d 0%,#f59e0b 50%,#d97706 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;font-size:2.8rem;font-weight:900;line-height:1;letter-spacing:-1px;">${{ number_format($whalePkg->price, 2) }}</div>
                    <div style="color:#52525b;font-size:12px;margin-bottom:18px;margin-top:4px;">{{ $whalePkg->duration ?? '12 Months' }} Access</div>
                    <div style="background:linear-gradient(135deg,#f59e0b 0%,#d97706 100%);color:#09090b;padding:12px 28px;border-radius:10px;font-weight:800;font-size:14px;display:inline-block;box-shadow:0 4px 18px rgba(245,158,11,0.35);letter-spacing:0.2px;">Become a Whale →</div>
                </div>
            </div>
        </a>
        @endif

        <p style="text-align:center;color:#71717a;margin-top:20px;font-size:14px;">Already have an account? <a href="{{ route('login') }}" style="color:#f59e0b;font-weight:600;">Login here</a></p>
    </div>
</div>
@endsection
