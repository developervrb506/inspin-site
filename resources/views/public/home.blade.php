@extends('layouts.public')
@section('title', 'INSPIN - Sports Betting Analysis & Picks')

@section('content')
{{-- ===== HERO ===== --}}
<div class="hero">
    <div class="container">
        <h1>INSPIN Simulation Model - <span>Up +150 Units</span> Over 3 Years</h1>
        <p>We simulate every NFL, NCAAF, NBA, NCAAB, NHL, and MLB game thousands of times. A $100 bettor would have netted $15,000+ profit. Get access to all our picks and start winning.</p>
        <div class="hero-actions">
            <a href="{{ route('join') }}" class="btn btn-red">Subscribe Now</a>
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
<div class="section" style="background:#0a0a0a;color:white;padding:40px 0;">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
            <div>
                <h2 class="section-title" style="color:white;margin-bottom:4px;">Active Picks</h2>
                <p style="color:#94a3b8;margin:0;font-size:14px;">Current picks — login to see full details</p>
            </div>
            <a href="{{ route('picks') }}" style="color:#fbbf24;font-weight:700;font-size:14px;text-decoration:none;">View All Picks →</a>
        </div>

        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;font-size:14px;">
                <thead>
                    <tr style="border-bottom:1px solid #fbbf24;">
                        <th style="text-align:left;padding:10px 12px;color:#fbbf24;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;">Sport</th>
                        <th style="text-align:left;padding:10px 12px;color:#fbbf24;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Matchup</th>
                        <th style="text-align:left;padding:10px 12px;color:#fbbf24;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;">Date</th>
                        <th style="text-align:left;padding:10px 12px;color:#fbbf24;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;">Time</th>
                        <th style="text-align:left;padding:10px 12px;color:#fbbf24;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Status</th>
                        <th style="text-align:left;padding:10px 12px;color:#fbbf24;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Stars</th>
                        <th style="text-align:right;padding:10px 12px;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expertPicks as $pick)
                    @php
                        $timeStr = $pick->game_time ? \Carbon\Carbon::parse($pick->game_time)->format('H:i:s') : '00:00:00';
                        $gameStart = \Carbon\Carbon::parse($pick->game_date->format('Y-m-d') . ' ' . $timeStr);
                        $status = $pick->result !== 'pending' ? 'GRADED' : ($gameStart->isPast() ? 'STARTED' : 'ACTIVE');
                        $statusColor = $status === 'ACTIVE' ? '#22c55e' : ($status === 'STARTED' ? '#f59e0b' : '#94a3b8');
                        $statusBg = $status === 'ACTIVE' ? 'rgba(34,197,94,0.1)' : ($status === 'STARTED' ? 'rgba(245,158,11,0.1)' : 'rgba(148,163,184,0.1)');
                    @endphp
                    <tr style="border-bottom:1px solid #1f1f1f;transition:background 0.15s;" onmouseover="this.style.background='#111'" onmouseout="this.style.background='transparent'">
                        <td style="padding:14px 12px;">
                            <span style="background:#1e3a5f;color:#93c5fd;padding:3px 10px;border-radius:4px;font-size:11px;font-weight:700;">{{ $pick->sport }}</span>
                        </td>
                        <td style="padding:14px 12px;font-weight:600;color:white;">
                            {{ $pick->team1_name }} <span style="color:#64748b;font-size:12px;">vs</span> {{ $pick->team2_name }}
                        </td>
                        <td style="padding:14px 12px;color:#94a3b8;white-space:nowrap;">{{ $pick->game_date?->format('M d, Y') ?? 'TBD' }}</td>
                        <td style="padding:14px 12px;color:#94a3b8;white-space:nowrap;">{{ $pick->game_time ? \Carbon\Carbon::parse($pick->game_time)->format('g:i A') : 'TBD' }}</td>
                        <td style="padding:14px 12px;">
                            <span style="background:{{ $statusBg }};color:{{ $statusColor }};border:1px solid {{ $statusColor }}44;padding:3px 10px;border-radius:4px;font-size:11px;font-weight:700;">{{ $status }}</span>
                        </td>
                        <td style="padding:14px 12px;color:#fbbf24;font-size:14px;">
                            @if($pick->stars === 10)
                                <span style="color:#fbbf24;font-weight:700;font-size:12px;">★10 WHALE</span>
                            @else
                                {{ str_repeat('★', $pick->stars) }}<span style="color:#374151;">{{ str_repeat('★', 5 - $pick->stars) }}</span>
                            @endif
                        </td>
                        <td style="padding:14px 12px;text-align:right;">
                            @auth
                                <a href="{{ route('picks') }}" style="display:inline-block;padding:8px 18px;background:#dc2626;color:white;border-radius:6px;font-weight:700;font-size:13px;text-decoration:none;white-space:nowrap;">View Pick</a>
                            @else
                                <button onclick="openModal('join')" style="padding:8px 18px;background:#dc2626;color:white;border:none;border-radius:6px;font-weight:700;cursor:pointer;font-size:13px;white-space:nowrap;">View Pick</button>
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
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:32px;">
            @foreach($featuredPackages as $pkg)
            @php
                $isPopular = $pkg->slug === 'monthly';
                $isBest = $pkg->slug === 'semi-annual';
                $isFree = $pkg->slug === 'free-trial';
                $hasBadge = $isPopular || $isBest || $isFree;
            @endphp
            <div style="background:#fff;border-radius:16px;padding:28px 24px;text-align:center;position:relative;border:2px solid {{ $isPopular ? '#0a0a0a' : '#e2e8f0' }};box-shadow:{{ $isPopular ? '0 8px 32px rgba(0,0,0,0.12)' : '0 2px 8px rgba(0,0,0,0.05)' }};display:flex;flex-direction:column;">
                @if($isPopular)
                <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:#0a0a0a;color:#fbbf24;padding:4px 18px;border-radius:20px;font-size:11px;font-weight:700;letter-spacing:0.5px;white-space:nowrap;">MOST POPULAR</div>
                @elseif($isBest)
                <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:#0a0a0a;color:#fbbf24;padding:4px 18px;border-radius:20px;font-size:11px;font-weight:700;letter-spacing:0.5px;white-space:nowrap;">BEST VALUE</div>
                @elseif($isFree)
                <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:#22c55e;color:#fff;padding:4px 18px;border-radius:20px;font-size:11px;font-weight:700;letter-spacing:0.5px;white-space:nowrap;">START FREE</div>
                @endif

                <div style="font-size:1rem;font-weight:700;color:#0f172a;margin-bottom:4px;margin-top:{{ $hasBadge ? '8px' : '0' }};">{{ $pkg->name }}</div>
                <div style="color:#64748b;font-size:12px;margin-bottom:20px;">{{ $pkg->duration }} Access</div>

                <div style="margin-bottom:20px;">
                    @if($isFree)
                    <div style="font-size:2.8rem;font-weight:900;color:#0f172a;line-height:1;">FREE</div>
                    <div style="font-size:12px;color:#64748b;margin-top:4px;">No credit card needed</div>
                    @else
                    <div style="font-size:2.4rem;font-weight:900;color:#0f172a;line-height:1;"><sup style="font-size:1rem;color:#64748b;vertical-align:top;margin-top:8px;">$</sup>{{ number_format($pkg->price, 2) }}</div>
                    @endif
                </div>

                <ul style="list-style:none;text-align:left;margin:0 0 24px;padding:0;flex:1;">
                    @foreach(array_slice($pkg->features ?? [], 0, 5) as $feature)
                    <li style="padding:6px 0;font-size:13px;color:#475569;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;gap:8px;">
                        <span style="color:#22c55e;font-weight:700;flex-shrink:0;">✓</span>{{ $feature }}
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('join') }}" style="display:block;width:100%;padding:12px;border-radius:10px;font-weight:700;font-size:14px;text-decoration:none;text-align:center;background:{{ $isPopular ? '#0a0a0a' : ($isFree ? '#22c55e' : '#1e3a5f') }};color:{{ $isPopular ? '#fbbf24' : '#fff' }};">
                    {{ $isFree ? 'Start Free Trial' : 'Get Started' }}
                </a>
            </div>
            @endforeach
        </div>

        {{-- Whale Banner --}}
        @if($whaleRegular || $whalePackages->count() > 0)
        @php $whalePkg = $whaleRegular ?? $whalePackages->first(); @endphp
        <a href="{{ route('join') }}" style="display:block;text-decoration:none;background:linear-gradient(135deg,#111 0%,#0a0a0a 100%);border-radius:16px;padding:32px 40px;position:relative;overflow:hidden;border:2px solid #fbbf24;">
            <div style="position:absolute;top:0;right:0;width:200px;height:100%;background:radial-gradient(circle at 80% 50%,rgba(251,191,36,0.15) 0%,transparent 70%);"></div>
            <div style="display:flex;align-items:center;justify-content:space-between;gap:24px;position:relative;z-index:1;flex-wrap:wrap;">
                <div style="display:flex;align-items:center;gap:20px;">
                    <div style="font-size:3rem;line-height:1;">🐋</div>
                    <div>
                        <div style="color:#fbbf24;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;margin-bottom:4px;">Premium Access</div>
                        <div style="color:#fff;font-size:1.4rem;font-weight:800;margin-bottom:6px;">{{ $whalePkg->name ?? $whalePkg->title ?? 'Whale Package' }}</div>
                        <div style="display:flex;gap:16px;flex-wrap:wrap;">
                            @foreach(array_slice(($whalePkg->features ?? []), 0, 4) as $feat)
                            <span style="color:#94a3b8;font-size:13px;display:flex;align-items:center;gap:4px;"><span style="color:#fbbf24;">★</span>{{ $feat }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div style="text-align:center;flex-shrink:0;">
                    <div style="color:#fbbf24;font-size:2.5rem;font-weight:900;line-height:1;">${{ number_format($whalePkg->price, 2) }}</div>
                    <div style="color:#94a3b8;font-size:12px;margin-bottom:16px;">{{ $whalePkg->duration ?? '12 Months' }} Access</div>
                    <div style="background:#fbbf24;color:#0a0a0a;padding:12px 28px;border-radius:10px;font-weight:800;font-size:14px;display:inline-block;">Become a Whale →</div>
                </div>
            </div>
        </a>
        @endif

        <div style="text-align:center;margin-top:20px;">
            <a href="{{ route('join') }}" style="color:#64748b;font-size:14px;text-decoration:none;">View all packages & pricing →</a>
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
