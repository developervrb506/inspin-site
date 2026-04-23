@extends('layouts.public')
@section('title', 'Join INSPIN - Membership Packages')

@push('styles')
<style>
    .pkg-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 20px; }
    @media(max-width:900px){ .pkg-grid { grid-template-columns: repeat(2,1fr); } }
    @media(max-width:560px){ .pkg-grid { grid-template-columns: 1fr; } }
    @media(max-width:560px){ .whale-inner { flex-direction:column !important; text-align:center !important; } .whale-price-block { width:100% !important; } }
</style>
@endpush

@section('content')

{{-- Hero --}}
<section style="background:#171818;padding:70px 0 60px;text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;pointer-events:none;background-image:linear-gradient(rgba(255,252,238,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(255,252,238,.03) 1px,transparent 1px);background-size:68px 68px;"></div>
    <div style="position:absolute;bottom:0;left:0;right:0;height:1.5px;background:linear-gradient(90deg,transparent 5%,#c47f10 30%,#FDB515 50%,#c47f10 70%,transparent 95%);"></div>
    <div class="container" style="position:relative;">
        <h1 style="font-family:'Clash Display',sans-serif;color:#FFFCEE;font-size:2.2rem;font-weight:500;margin-bottom:12px;letter-spacing:-.2px;">Membership Packages</h1>
        <p style="color:#6e6e6e;max-width:560px;margin:0 auto 10px;font-size:15px;">Start free. Upgrade anytime. Cancel anytime.</p>
        <p style="color:#9a9a9a;max-width:620px;margin:0 auto;font-size:14px;">Our simulation model is up <strong style="color:#FDB515;">+150 units</strong> over 3 years — a $100 bettor netted $15,000+ profit.</p>
    </div>
</section>

{{-- Packages Grid --}}
<div class="section">
    <div class="container">
        @php
            $featuredSlugs = ['free-trial','1-week','2-weeks','monthly','quarterly','semi-annual'];
            $featuredPackages = $packages->filter(fn($p) => in_array($p->slug,$featuredSlugs))->sortBy(fn($p) => array_search($p->slug,$featuredSlugs));
            $whaleRegular = $packages->firstWhere('slug','whale-package');
        @endphp

        <div class="pkg-grid" style="margin-bottom:32px;">
            @foreach($featuredPackages as $pkg)
            @php
                $isFree    = $pkg->slug === 'free-trial';
                $isMonthly = $pkg->slug === 'monthly';
                $isBest    = $pkg->slug === 'semi-annual';
                $hasBadge  = $isFree || $isMonthly || $isBest;
            @endphp
            <div style="background:#212121;border:1px solid rgba(255,252,238,.08);border-radius:12px;padding:28px 22px;text-align:center;position:relative;display:flex;flex-direction:column;transition:border-color .2s,box-shadow .2s;" onmouseover="this.style.borderColor='rgba(253,181,21,.35)';this.style.boxShadow='0 8px 32px rgba(0,0,0,.4)'" onmouseout="this.style.borderColor='rgba(255,252,238,.08)';this.style.boxShadow='none'">
                @if($isFree)
                <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:#22c55e;color:#fff;padding:4px 18px;border-radius:20px;font-size:10px;font-weight:700;letter-spacing:.6px;white-space:nowrap;box-shadow:0 2px 8px rgba(34,197,94,.4);">Starts Free</div>
                @elseif($isMonthly)
                <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:#FDB515;color:#171818;padding:4px 18px;border-radius:20px;font-size:10px;font-weight:700;letter-spacing:.6px;white-space:nowrap;box-shadow:0 2px 8px rgba(253,181,21,.4);">Most Popular</div>
                @elseif($isBest)
                <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:#2dd4bf;color:#171818;padding:4px 18px;border-radius:20px;font-size:10px;font-weight:700;letter-spacing:.6px;white-space:nowrap;box-shadow:0 2px 8px rgba(45,212,191,.4);">Best Value</div>
                @endif

                <div style="margin-top:{{ $hasBadge?'12px':'0' }}">
                    <p style="font-size:11.5px;color:#6e6e6e;margin-bottom:4px;letter-spacing:.3px;">{{ $pkg->duration }} Access</p>
                    <p style="font-family:'Clash Display',sans-serif;font-size:1rem;font-weight:500;color:#FFFCEE;margin-bottom:18px;">{{ $pkg->name }}</p>
                </div>

                <div style="margin-bottom:22px;">
                    @if($isFree)
                        <div style="font-family:'Clash Display',sans-serif;font-size:2.8rem;font-weight:600;color:#FFFCEE;line-height:1;letter-spacing:-1px;">FREE</div>
                        <div style="font-size:12px;color:#4ade80;margin-top:6px;">No credit card needed</div>
                    @else
                        <div style="font-family:'Clash Display',sans-serif;font-size:2.4rem;font-weight:600;color:#FFFCEE;line-height:1;letter-spacing:-1px;">
                            <sup style="font-size:.9rem;color:#6e6e6e;vertical-align:top;margin-top:9px;font-weight:500;">$</sup>{{ number_format($pkg->price,2) }}
                        </div>
                    @endif
                </div>

                <ul style="list-style:none;padding:0;margin:0 0 22px;flex:1;text-align:left;">
                    @foreach(array_slice($pkg->features??[],0,5) as $feat)
                    <li style="display:flex;align-items:center;gap:9px;padding:7px 0;font-size:13px;color:#9a9a9a;border-bottom:1px solid rgba(255,252,238,.06);">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" style="flex-shrink:0;"><circle cx="8" cy="8" r="8" fill="rgba(74,222,128,.12)"/><polyline points="5,8.5 7,10.5 11,6" stroke="#4ade80" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('register') }}"
                   style="display:block;text-align:center;padding:12px;border-radius:50px;font-weight:600;font-size:14px;text-decoration:none;transition:background .18s;border:1px solid {{ $isFree?'#22c55e':'#FDB515' }};color:{{ $isFree?'#22c55e':'#FDB515' }};background:transparent;"
                   onmouseover="this.style.background='{{ $isFree?'rgba(34,197,94,.1)':'rgba(253,181,21,.1)' }}'"
                   onmouseout="this.style.background='transparent'">
                    {{ $isFree ? 'Start Free Trial' : 'Get Started' }}
                </a>
            </div>
            @endforeach
        </div>

        {{-- Whale Banner --}}
        @php $whalePkg = $whaleRegular ?? $whalePackages->first(); @endphp
        @if($whalePkg)
        <a href="{{ route('register') }}" style="display:block;text-decoration:none;background:#212121;border-radius:16px;padding:36px 40px;position:relative;overflow:hidden;border:1px solid rgba(253,181,21,.2);box-shadow:0 0 40px rgba(253,181,21,.06);">
            <div style="position:absolute;top:0;right:0;width:300px;height:100%;background:radial-gradient(ellipse at 80% 50%,rgba(253,181,21,.08) 0%,transparent 65%);pointer-events:none;"></div>
            <div class="whale-inner" style="display:flex;align-items:center;justify-content:space-between;gap:24px;position:relative;z-index:1;flex-wrap:wrap;">
                <div style="display:flex;align-items:center;gap:20px;">
                    <div style="font-size:3rem;line-height:1;filter:drop-shadow(0 4px 12px rgba(253,181,21,.3));">🐋</div>
                    <div>
                        <div style="color:#FDB515;font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;margin-bottom:6px;">Premium Access</div>
                        <div style="font-family:'Clash Display',sans-serif;color:#FFFCEE;font-size:1.5rem;font-weight:500;margin-bottom:8px;">{{ $whalePkg->name ?? 'Whale Package' }}</div>
                        <div style="display:flex;gap:14px;flex-wrap:wrap;">
                            @foreach(array_slice(($whalePkg->features??[]),0,4) as $feat)
                            <span style="color:#6e6e6e;font-size:13px;display:flex;align-items:center;gap:5px;"><span style="color:#FDB515;font-size:10px;">★</span>{{ $feat }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="whale-price-block" style="text-align:center;flex-shrink:0;">
                    <div style="background:linear-gradient(135deg,#fdd060 0%,#FDB515 50%,#e09c0d 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;font-family:'Clash Display',sans-serif;font-size:2.8rem;font-weight:600;line-height:1;letter-spacing:-1px;">${{ number_format($whalePkg->price,2) }}</div>
                    <div style="color:#4a4a4a;font-size:12px;margin-bottom:18px;margin-top:4px;">{{ $whalePkg->duration ?? '12 Months' }} Access</div>
                    <div style="background:#FDB515;color:#171818;padding:12px 28px;border-radius:50px;font-weight:700;font-size:14px;display:inline-block;box-shadow:0 0 20px rgba(253,181,21,.35);">Become a Whale →</div>
                </div>
            </div>
        </a>
        @endif

        <p style="text-align:center;color:#6e6e6e;margin-top:20px;font-size:14px;">
            Already have an account? <button onclick="openModal()" style="background:none;border:none;color:#FDB515;font-weight:600;cursor:pointer;font-size:14px;">Login here</button>
        </p>
    </div>
</div>
@endsection
