@extends('layouts.public')
@section('title', 'INSPIN - Sports Betting Analysis & Picks')

@push('styles')
<style>
    /* Packages grid — 3 col desktop, 2 col tablet, 1 col mobile */
    .pkg-grid { grid-template-columns: repeat(3, 1fr); }
    @media (max-width: 900px) { .pkg-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px) { .pkg-grid { grid-template-columns: 1fr; } }

    /* Picks table — hide Date/Time columns on small screens */
    @media (max-width: 640px) {
        .picks-col-date, .picks-col-time { display: none; }
        .picks-col-matchup { max-width: 130px; overflow: hidden; text-overflow: ellipsis; }
    }

    /* Whale banner text on small screens */
    @media (max-width: 560px) {
        .whale-inner { flex-direction: column !important; text-align: center !important; }
        .whale-inner > div:first-child { justify-content: center !important; }
        .whale-price-block { width: 100% !important; }
    }

    /* Hero text adjustments */
    @media (max-width: 480px) {
        .hero h1 { font-size: 1.3rem !important; }
    }
</style>
@endpush

@section('content')
{{-- ===== HERO ===== --}}
<div class="hero">
    <div class="container">
        <h1>INSPIN Simulation/Handicapper Model – <span>Up +150 Units over 3 Years</span></h1>
        <p style="color:#fbbf24;font-size:15px;font-weight:600;margin-bottom:12px;position:relative;">($100 bettor won $15,000 / $500 bettor won $75,000 / $1,000 bettor won $150,000)</p>
        <p style="font-size:1.15rem;color:#fafafa;font-weight:700;margin-bottom:12px;position:relative;">Want to crush the books without the guesswork?</p>
        <p style="position:relative;">We're giving you <strong style="color:#fbbf24;">7 DAYS</strong> of premium handicapping picks absolutely <strong style="color:#fbbf24;">FREE</strong>. No strings, no "hidden" fees, and zero obligation to stay. Just pure, data-driven, analytic picks delivered straight to you.</p>
        <p style="margin-top:16px;position:relative;">Stop guessing and start winning. Claim your 7-day free trial now and see the difference professional research makes before you ever spend a dime. <strong style="color:#fbbf24;">Free Trial Click Below!</strong></p>
        <div class="hero-actions" style="margin-top:32px;">
            <a href="{{ route('join') }}" class="btn btn-green">Join Now</a>
        </div>
    </div>
</div>

{{-- ===== ARTICLES ===== --}}
@if($articles->count() > 0)
<div class="section section-alt">
    <div class="container">
        <h2 class="section-title">Exclusive Articles and Analysis</h2>
        <p class="section-sub">Expert picks, betting trends, and consensus analysis</p>
        <div class="grid grid-3">
            @foreach($articles as $article)
            <a href="{{ route('article.show', $article) }}" class="card" style="text-decoration:none;">
                <div class="card-body">
                    @if($article->featured_image)
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" style="width:100%;height:160px;object-fit:cover;border-radius:8px;margin-bottom:12px;">
                    @endif
                    <div style="display:flex;gap:6px;margin-bottom:8px;flex-wrap:wrap;">
                        <span class="badge badge-{{ strtolower($article->sport) }}">{{ $article->sport }}</span>
                        <span class="badge badge-{{ $article->category }}">{{ $article->category }}</span>
                        @if($article->is_premium)<span class="badge badge-premium">Premium</span>@endif
                    </div>
                    <h3>{{ $article->title }}</h3>
                    <p>{{ Str::limit(strip_tags($article->excerpt), 120) }}</p>
                    <div class="card-meta">
                        <span>{{ $article->author }}</span>
                        <span>{{ $article->published_at?->format('M d, Y') ?? '' }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:24px;">
            <a href="{{ route('articles') }}" class="btn btn-outline-dark">View All Articles</a>
        </div>
    </div>
</div>
@endif

{{-- ===== ACTIVE PICKS ===== --}}
@if($expertPicks->count() > 0)
<div class="section" style="background:radial-gradient(ellipse at 50% 0%,#1c1917 0%,#09090b 60%);color:white;padding:52px 0;position:relative;overflow:hidden;">
    <div style="position:absolute;inset:0;background:url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23f59e0b\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');pointer-events:none;"></div>
    <div class="container" style="position:relative;">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:28px;flex-wrap:wrap;gap:12px;">
            <div>
                <h2 style="color:#fafafa;font-size:1.85rem;font-weight:900;letter-spacing:-0.3px;margin-bottom:4px;padding-left:16px;border-left:4px solid #f59e0b;">Active Picks</h2>
                <p style="color:#71717a;margin:0;font-size:14px;padding-left:20px;">Current picks — login to see full details</p>
            </div>
            <a href="{{ route('picks') }}" style="display:inline-flex;align-items:center;gap:6px;color:#f59e0b;font-weight:700;font-size:14px;text-decoration:none;padding:8px 16px;border:1px solid #27272a;border-radius:8px;background:rgba(245,158,11,0.05);transition:all 0.2s;" onmouseover="this.style.background='rgba(245,158,11,0.12)'" onmouseout="this.style.background='rgba(245,158,11,0.05)'">View All Picks <span style="font-size:16px;">→</span></a>
        </div>

        <div style="overflow-x:auto;border-radius:14px;border:1px solid #27272a;box-shadow:0 4px 24px rgba(0,0,0,0.4);">
            <table style="width:100%;border-collapse:collapse;font-size:14px;background:rgba(24,24,27,0.8);">
                <thead>
                    <tr style="border-bottom:1px solid #27272a;">
                        <th style="text-align:left;padding:12px 16px;color:#f59e0b;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;white-space:nowrap;background:rgba(9,9,11,0.6);">Sport</th>
                        <th class="picks-col-matchup" style="text-align:left;padding:12px 16px;color:#f59e0b;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;background:rgba(9,9,11,0.6);">Matchup</th>
                        <th class="picks-col-date" style="text-align:left;padding:12px 16px;color:#f59e0b;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;white-space:nowrap;background:rgba(9,9,11,0.6);">Date</th>
                        <th class="picks-col-time" style="text-align:left;padding:12px 16px;color:#f59e0b;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;white-space:nowrap;background:rgba(9,9,11,0.6);">Time</th>
                        <th style="text-align:left;padding:12px 16px;color:#f59e0b;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;background:rgba(9,9,11,0.6);">Status</th>
                        <th style="text-align:left;padding:12px 16px;color:#f59e0b;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:0.7px;background:rgba(9,9,11,0.6);">Stars</th>
                        <th style="text-align:right;padding:12px 16px;background:rgba(9,9,11,0.6);"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expertPicks as $pick)
                    @php
                        $timeStr = $pick->game_time ? \Carbon\Carbon::parse($pick->game_time)->format('H:i:s') : '00:00:00';
                        $gameStart = \Carbon\Carbon::parse($pick->game_date->format('Y-m-d') . ' ' . $timeStr);
                        $status = $pick->result !== 'pending' ? 'GRADED' : ($gameStart->isPast() ? 'LIVE' : 'UPCOMING');
                        $statusColor = $status === 'UPCOMING' ? '#4ade80' : ($status === 'LIVE' ? '#fcd34d' : '#71717a');
                        $statusBg = $status === 'UPCOMING' ? 'rgba(74,222,128,0.1)' : ($status === 'LIVE' ? 'rgba(252,211,77,0.1)' : 'rgba(113,113,122,0.1)');
                        $statusBorder = $status === 'UPCOMING' ? 'rgba(74,222,128,0.3)' : ($status === 'LIVE' ? 'rgba(252,211,77,0.3)' : 'rgba(113,113,122,0.3)');
                    @endphp
                    <tr style="border-bottom:1px solid #1f1f23;transition:background 0.15s;" onmouseover="this.style.background='rgba(245,158,11,0.04)'" onmouseout="this.style.background='transparent'">
                        <td style="padding:15px 16px;">
                            <span style="background:rgba(30,58,95,0.8);color:#93c5fd;padding:3px 10px;border-radius:5px;font-size:11px;font-weight:700;border:1px solid rgba(147,197,253,0.15);">{{ $pick->sport }}</span>
                        </td>
                        <td class="picks-col-matchup" style="padding:15px 16px;font-weight:600;color:#fafafa;white-space:nowrap;">
                            {{ $pick->team1_name }} <span style="color:#52525b;font-size:12px;margin:0 4px;">vs</span> {{ $pick->team2_name }}
                        </td>
                        <td class="picks-col-date" style="padding:15px 16px;color:#a1a1aa;white-space:nowrap;font-size:13px;">{{ $pick->game_date?->format('M d, Y') ?? 'TBD' }}</td>
                        <td class="picks-col-time" style="padding:15px 16px;color:#a1a1aa;white-space:nowrap;font-size:13px;">{{ $pick->game_time ? \Carbon\Carbon::parse($pick->game_time)->format('g:i A') . ' ET' : 'TBD' }}</td>
                        <td style="padding:15px 16px;">
                            <span style="background:{{ $statusBg }};color:{{ $statusColor }};border:1px solid {{ $statusBorder }};padding:3px 10px;border-radius:5px;font-size:10.5px;font-weight:700;letter-spacing:0.3px;">{{ $status }}</span>
                        </td>
                        <td style="padding:15px 16px;font-size:14px;">
                            @if($pick->stars === 10)
                                <span style="background:linear-gradient(135deg,#f59e0b,#d97706);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-weight:800;font-size:12px;">★10 WHALE</span>
                            @else
                                <span style="color:#f59e0b;">{{ str_repeat('★', $pick->stars) }}</span><span style="color:#27272a;">{{ str_repeat('★', 5 - $pick->stars) }}</span>
                            @endif
                        </td>
                        <td style="padding:15px 16px;text-align:right;">
                            @auth
                                <a href="{{ route('picks') }}" style="display:inline-block;padding:7px 18px;background:linear-gradient(135deg,#ef4444,#dc2626);color:white;border-radius:7px;font-weight:700;font-size:13px;text-decoration:none;white-space:nowrap;box-shadow:0 2px 8px rgba(220,38,38,0.3);transition:all 0.2s;" onmouseover="this.style.boxShadow='0 4px 14px rgba(220,38,38,0.45)';this.style.transform='translateY(-1px)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(220,38,38,0.3)';this.style.transform='translateY(0)'">View Pick</a>
                            @else
                                <button onclick="openModal('join')" style="padding:7px 18px;background:linear-gradient(135deg,#ef4444,#dc2626);color:white;border:none;border-radius:7px;font-weight:700;cursor:pointer;font-size:13px;white-space:nowrap;box-shadow:0 2px 8px rgba(220,38,38,0.3);transition:all 0.2s;" onmouseover="this.style.boxShadow='0 4px 14px rgba(220,38,38,0.45)';this.style.transform='translateY(-1px)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(220,38,38,0.3)';this.style.transform='translateY(0)'">View Pick</button>
                            @endauth
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

{{-- ===== PACKAGES ===== --}}
@php
    $featuredSlugs = ['free-trial', '1-week', '2-weeks', 'monthly', 'quarterly', 'semi-annual'];
    $featuredPackages = $packages->filter(fn($p) => in_array($p->slug, $featuredSlugs))->sortBy(fn($p) => array_search($p->slug, $featuredSlugs));
    $whaleRegular = $packages->firstWhere('slug', 'whale-package');
@endphp
<div class="section section-alt">
    <div class="container">
        <div style="text-align:center;margin-bottom:48px;">
            <h2 class="section-title" style="margin-bottom:8px;">Membership Packages</h2>
            <p class="section-sub">Start free. Upgrade anytime. Cancel anytime.</p>
        </div>

        {{-- 3×2 Pricing Grid --}}
        <div class="pkg-grid" style="display:grid;gap:20px;margin-bottom:32px;">
            @foreach($featuredPackages as $pkg)
            @php
                $isPopular = $pkg->slug === 'monthly';
                $isBest = $pkg->slug === 'semi-annual';
                $isFree = $pkg->slug === 'free-trial';
                $hasBadge = $isPopular || $isBest || $isFree;
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

                <a href="{{ route('join') }}" style="display:block;width:100%;padding:12px;border-radius:10px;font-weight:700;font-size:14px;text-decoration:none;text-align:center;background:{{ $isPopular ? 'linear-gradient(135deg,#09090b,#18181b)' : ($isFree ? 'linear-gradient(135deg,#22c55e,#16a34a)' : 'linear-gradient(135deg,#1e3a5f,#0f2340)') }};color:{{ $isPopular ? '#f59e0b' : '#fff' }};box-shadow:{{ $isPopular ? '0 4px 14px rgba(0,0,0,0.2)' : '0 2px 8px rgba(0,0,0,0.1)' }};letter-spacing:0.1px;">
                    {{ $isFree ? 'Start Free Trial' : 'Get Started' }}
                </a>
            </div>
            @endforeach
        </div>

        {{-- Whale Banner --}}
        @if($whaleRegular || $whalePackages->count() > 0)
        @php $whalePkg = $whaleRegular ?? $whalePackages->first(); @endphp
        <a href="{{ route('join') }}" style="display:block;text-decoration:none;background:linear-gradient(135deg,#09090b 0%,#1c1917 50%,#09090b 100%);border-radius:18px;padding:36px 40px;position:relative;overflow:hidden;border:1px solid #27272a;box-shadow:0 8px 40px rgba(0,0,0,0.3),0 0 0 1px rgba(245,158,11,0.1);">
            <div style="position:absolute;top:0;right:0;width:300px;height:100%;background:radial-gradient(ellipse at 80% 50%,rgba(245,158,11,0.12) 0%,transparent 65%);pointer-events:none;"></div>
            <div style="position:absolute;top:-60px;right:60px;width:160px;height:160px;background:radial-gradient(circle,rgba(245,158,11,0.08) 0%,transparent 70%);pointer-events:none;"></div>
            <div style="position:absolute;bottom:0;left:0;right:0;height:1px;background:linear-gradient(90deg,transparent,rgba(245,158,11,0.3),transparent);pointer-events:none;"></div>
            <div class="whale-inner" style="display:flex;align-items:center;justify-content:space-between;gap:24px;position:relative;z-index:1;flex-wrap:wrap;">
                <div style="display:flex;align-items:center;gap:20px;">
                    <div style="font-size:3.2rem;line-height:1;filter:drop-shadow(0 4px 12px rgba(245,158,11,0.3));">🐋</div>
                    <div>
                        <div style="color:#f59e0b;font-size:10.5px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;margin-bottom:6px;display:flex;align-items:center;gap:6px;"><span style="width:20px;height:1px;background:linear-gradient(90deg,#f59e0b,transparent);display:inline-block;"></span>Premium Access</div>
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

        <div style="text-align:center;margin-top:20px;">
            <a href="{{ route('join') }}" style="color:#71717a;font-size:14px;text-decoration:none;transition:color 0.15s;" onmouseover="this.style.color='#f59e0b'" onmouseout="this.style.color='#71717a'">View all packages & pricing →</a>
        </div>
    </div>
</div>

{{-- ===== SPORTS ===== --}}
<div class="section">
    <div class="container">
        <h2 class="section-title">Sports We Cover</h2>
        <p class="section-sub">Expert handicapping for all major US sports</p>
        <div class="grid grid-3">
            <div class="card" style="text-align:center;padding:24px;">
                <div style="font-size:2.5rem;margin-bottom:8px;">🏈</div>
                <h3>NFL</h3>
                <p>Weekly picks, playoff analysis, Super Bowl predictions</p>
            </div>
            <div class="card" style="text-align:center;padding:24px;">
                <div style="font-size:2.5rem;margin-bottom:8px;">🏈</div>
                <h3>NCAAF</h3>
                <p>College football picks, bowl games, championship analysis</p>
            </div>
            <div class="card" style="text-align:center;padding:24px;">
                <div style="font-size:2.5rem;margin-bottom:8px;">🏀</div>
                <h3>NBA</h3>
                <p>Daily picks, consensus data, simulation model</p>
            </div>
            <div class="card" style="text-align:center;padding:24px;">
                <div style="font-size:2.5rem;margin-bottom:8px;">🏀</div>
                <h3>NCAAB</h3>
                <p>March Madness, college basketball picks and trends</p>
            </div>
            <div class="card" style="text-align:center;padding:24px;">
                <div style="font-size:2.5rem;margin-bottom:8px;">⚾</div>
                <h3>MLB</h3>
                <p>162-game season picks, playoff tracking</p>
            </div>
            <div class="card" style="text-align:center;padding:24px;">
                <div style="font-size:2.5rem;margin-bottom:8px;">🏒</div>
                <h3>NHL</h3>
                <p>Stanley Cup picks, goalie analysis, trends</p>
            </div>
        </div>
    </div>
</div>

<div class="section section-alt">
    <div class="container">
        <div class="cta">
            <h2>Start Winning with INSPIN Today</h2>
            <p>Our simulation model has been up over 150 units in the last 3 years. Don't miss out.</p>
            <a href="{{ route('join') }}" class="btn" style="background:#fbbf24;color:#0a0a0a;">Open a Package Now</a>
        </div>
    </div>
</div>
@endsection
