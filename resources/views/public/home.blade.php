@extends('layouts.public')
@section('title', 'INSPIN - Sports Betting Analysis & Picks')

@push('styles')
<style>
    /* Packages grid */
    .pkg-grid { grid-template-columns: repeat(3, 1fr); }
    @media (max-width: 900px) { .pkg-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px) { .pkg-grid { grid-template-columns: 1fr; } }

    /* Picks card grid */
    .picks-grid { grid-template-columns: repeat(2, 1fr); }
    @media (max-width: 700px) { .picks-grid { grid-template-columns: 1fr; } }

    /* Articles grid */
    .articles-grid { grid-template-columns: repeat(3, 1fr); }
    @media (max-width: 900px) { .articles-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 560px) { .articles-grid { grid-template-columns: 1fr; } }

    /* Hero */
    @media (max-width: 480px) { .hero h1 { font-size: 1.3rem !important; } }

    /* Pick card team logo circle */
    .team-initials {
        width: 28px; height: 28px; border-radius: 50%;
        background: #27272a; color: #a1a1aa;
        display: flex; align-items: center; justify-content: center;
        font-size: 9px; font-weight: 700; flex-shrink: 0;
    }

    /* Article card arrows */
    .articles-nav-btn {
        width: 36px; height: 36px; border-radius: 50%;
        border: 1.5px solid #f59e0b; background: transparent;
        color: #f59e0b; font-size: 18px; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.18s, color 0.18s;
        flex-shrink: 0;
    }
    .articles-nav-btn:hover { background: #f59e0b; color: #09090b; }

    /* Pick card hover */
    .pick-card { transition: border-color 0.18s, box-shadow 0.18s; }
    .pick-card:hover { border-color: #3f3f46; box-shadow: 0 8px 32px rgba(0,0,0,0.4); }

    /* See More link */
    .hero-see-more {
        display: inline-block; color: #a1a1aa; font-size: 13px;
        text-decoration: underline; margin-bottom: 20px;
        position: relative; cursor: pointer;
        transition: color 0.15s;
    }
    .hero-see-more:hover { color: #f59e0b; }
</style>
@endpush

@section('content')

{{-- ===== HERO ===== --}}
<div class="hero">
    <div class="container" style="text-align:center;">
        <h1>INSPIN Simulation/Handicapper Model – <span>Up +150 Units over 3 Years</span></h1>
        <p style="color:#fbbf24;font-size:15px;font-weight:600;margin-bottom:14px;position:relative;">
            ($100 bettor won $15,000 / $500 bettor won $75,000 / $1,000 bettor won $150,000)
        </p>
        <p style="font-size:1.1rem;color:#fafafa;font-weight:600;margin-bottom:16px;position:relative;">
            Want to crush the books without the guesswork?
        </p>
        <p style="position:relative;margin-bottom:8px;">
            <a href="{{ route('join') }}" class="hero-see-more">See More</a>
        </p>
        <div class="hero-actions" style="margin-top:8px;">
            <a href="{{ route('join') }}" class="btn btn-green">Join Now</a>
        </div>
    </div>
</div>

{{-- ===== ARTICLES ===== --}}
@if($articles->count() > 0)
<div class="section section-alt">
    <div class="container">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;gap:12px;flex-wrap:wrap;">
            <div>
                <h2 class="section-title" style="margin-bottom:4px;">Exclusive Articles and Analysis</h2>
                <p class="section-sub" style="margin:0;">Want to crush the books without the guesswork?</p>
            </div>
            <div style="display:flex;gap:8px;flex-shrink:0;">
                <button class="articles-nav-btn" onclick="scrollArticles(-1)" aria-label="Previous articles">&#8249;</button>
                <button class="articles-nav-btn" onclick="scrollArticles(1)" aria-label="Next articles">&#8250;</button>
            </div>
        </div>

        <div id="articlesTrack" style="overflow:hidden;">
            <div class="articles-grid" style="display:grid;gap:20px;">
                @foreach($articles as $article)
                <a href="{{ route('article.show', $article) }}" class="card" style="text-decoration:none;display:flex;flex-direction:column;">
                    <div class="card-body" style="display:flex;flex-direction:column;flex:1;">
                        @if($article->featured_image)
                        <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}"
                             style="width:100%;height:165px;object-fit:cover;border-radius:8px;margin-bottom:12px;">
                        @endif
                        <div style="display:flex;gap:6px;margin-bottom:8px;flex-wrap:wrap;">
                            <span class="badge badge-{{ strtolower($article->sport ?? 'default') }}">{{ $article->sport }}</span>
                            <span class="badge" style="background:rgba(30,58,95,0.6);color:#93c5fd;font-size:10px;padding:2px 8px;border-radius:4px;">{{ $article->category }}</span>
                            @if($article->is_premium)<span class="badge badge-premium">Premium</span>@endif
                        </div>
                        <h3 style="font-size:15px;font-weight:700;margin-bottom:8px;line-height:1.35;color:#fafafa;">{{ $article->title }}</h3>
                        <p style="font-size:13px;color:#a1a1aa;line-height:1.5;flex:1;margin-bottom:12px;">{{ Str::limit(strip_tags($article->excerpt), 120) }}</p>
                        <div class="card-meta" style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:24px;height:24px;border-radius:50%;background:#27272a;display:flex;align-items:center;justify-content:center;font-size:10px;color:#a1a1aa;font-weight:700;flex-shrink:0;">
                                    {{ strtoupper(substr($article->author ?? 'A', 0, 1)) }}
                                </div>
                                <span style="font-size:12px;color:#a1a1aa;">{{ $article->author }}</span>
                            </div>
                            <span style="font-size:12px;color:#52525b;display:flex;align-items:center;gap:4px;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $article->published_at?->format('M d, Y') ?? '' }}
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
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
                <h2 style="color:#fafafa;font-size:1.85rem;font-weight:900;letter-spacing:-0.3px;margin-bottom:4px;">Active Picks</h2>
                <p style="color:#71717a;margin:0;font-size:14px;">Current picks — login to see full details</p>
            </div>
            <a href="{{ route('picks') }}" style="display:inline-flex;align-items:center;gap:6px;color:#f59e0b;font-weight:700;font-size:13px;text-decoration:none;padding:8px 16px;border:1px solid #f59e0b;border-radius:20px;background:transparent;transition:all 0.2s;" onmouseover="this.style.background='rgba(245,158,11,0.1)'" onmouseout="this.style.background='transparent'">View All Picks</a>
        </div>

        <div class="picks-grid" style="display:grid;gap:16px;">
            @foreach($expertPicks as $pick)
            @php
                $timeStr = $pick->game_time ? \Carbon\Carbon::parse($pick->game_time)->format('H:i:s') : '00:00:00';
                $gameStart = \Carbon\Carbon::parse($pick->game_date->format('Y-m-d') . ' ' . $timeStr);
                $status = $pick->result !== 'pending' ? 'GRADED' : ($gameStart->isPast() ? 'LIVE' : 'UPCOMING');
                $isLive = $status === 'LIVE';
                $sportEmojis = ['MLB'=>'⚾','NFL'=>'🏈','NBA'=>'🏀','NHL'=>'🏒','NCAAF'=>'🏈','NCAAB'=>'🏀','MMA'=>'🥊','GOLF'=>'⛳'];
                $sportEmoji = $sportEmojis[$pick->sport] ?? '🏅';
                $team1Init = strtoupper(substr($pick->team1_name ?? 'T', 0, 2));
                $team2Init = strtoupper(substr($pick->team2_name ?? 'T', 0, 2));
            @endphp
            <div class="pick-card" style="background:#18181b;border:1px solid #27272a;border-radius:14px;padding:20px;">
                {{-- Top row: sport + stars --}}
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="font-size:20px;line-height:1;">{{ $sportEmoji }}</span>
                        <span style="color:#a1a1aa;font-size:12px;font-weight:700;letter-spacing:0.5px;">{{ $pick->sport }}</span>
                    </div>
                    <div style="font-size:15px;line-height:1;">
                        @if($pick->stars === 10)
                            <span style="color:#f59e0b;font-size:11px;font-weight:800;">★10 WHALE</span>
                        @else
                            <span style="color:#f59e0b;">{{ str_repeat('★', $pick->stars) }}</span><span style="color:#3f3f46;">{{ str_repeat('★', max(0, 5 - $pick->stars)) }}</span>
                        @endif
                    </div>
                </div>

                {{-- Status + time --}}
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:16px;">
                    @if($isLive)
                    <span style="display:flex;align-items:center;gap:5px;font-size:11px;font-weight:700;color:#ef4444;letter-spacing:0.3px;">
                        <span style="width:7px;height:7px;border-radius:50%;background:#ef4444;display:inline-block;animation:pulse 1.4s infinite;"></span>LIVE
                    </span>
                    @elseif($status === 'UPCOMING')
                    <span style="display:flex;align-items:center;gap:5px;font-size:11px;font-weight:700;color:#4ade80;">UPCOMING</span>
                    @else
                    <span style="font-size:11px;font-weight:700;color:#71717a;">GRADED</span>
                    @endif
                    <span style="color:#52525b;font-size:11px;">
                        {{ $pick->game_date?->format('M d') }}
                        @if($pick->game_time) @ {{ \Carbon\Carbon::parse($pick->game_time)->format('g:i A') }} ET @endif
                    </span>
                </div>

                {{-- Teams --}}
                <div style="display:flex;flex-direction:column;gap:10px;margin-bottom:18px;">
                    {{-- Team 1 --}}
                    <div style="display:flex;align-items:center;gap:10px;">
                        @if($pick->team1_logo)
                            <img src="{{ $pick->team1_logo }}" alt="{{ $pick->team1_name }}" style="width:28px;height:28px;border-radius:50%;object-fit:contain;background:#27272a;flex-shrink:0;">
                        @else
                            <div class="team-initials">{{ $team1Init }}</div>
                        @endif
                        <span style="color:#fafafa;font-size:13px;font-weight:600;flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $pick->team1_name }}</span>
                    </div>
                    {{-- Team 2 --}}
                    <div style="display:flex;align-items:center;gap:10px;">
                        @if($pick->team2_logo)
                            <img src="{{ $pick->team2_logo }}" alt="{{ $pick->team2_name }}" style="width:28px;height:28px;border-radius:50%;object-fit:contain;background:#27272a;flex-shrink:0;">
                        @else
                            <div class="team-initials">{{ $team2Init }}</div>
                        @endif
                        <span style="color:#fafafa;font-size:13px;font-weight:600;flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $pick->team2_name }}</span>
                    </div>
                </div>

                {{-- Action --}}
                <div>
                    @auth
                        <a href="{{ route('picks') }}" style="display:block;text-align:center;padding:9px 0;background:transparent;border:1.5px solid #27272a;border-radius:8px;color:#a1a1aa;font-weight:700;font-size:13px;text-decoration:none;transition:border-color 0.15s,color 0.15s;" onmouseover="this.style.borderColor='#f59e0b';this.style.color='#f59e0b'" onmouseout="this.style.borderColor='#27272a';this.style.color='#a1a1aa'">View Pick</a>
                    @else
                        <button onclick="openModal('join')" style="display:block;width:100%;text-align:center;padding:9px 0;background:transparent;border:1.5px solid #27272a;border-radius:8px;color:#a1a1aa;font-weight:700;font-size:13px;cursor:pointer;transition:border-color 0.15s,color 0.15s;" onmouseover="this.style.borderColor='#f59e0b';this.style.color='#f59e0b'" onmouseout="this.style.borderColor='#27272a';this.style.color='#a1a1aa'">View Pick</button>
                    @endauth
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ===== PACKAGES ===== --}}
@php
    $featuredSlugs = ['free-trial', '1-week', '2-weeks', 'monthly', 'quarterly', 'semi-annual'];
    $featuredPackages = $packages->filter(fn($p) => in_array($p->slug, $featuredSlugs))->sortBy(fn($p) => array_search($p->slug, $featuredSlugs));
@endphp
<div class="section section-alt">
    <div class="container">
        <div style="margin-bottom:40px;">
            <h2 class="section-title" style="margin-bottom:6px;">Membership Packages</h2>
            <p class="section-sub">Start free. Upgrade anytime. Cancel anytime.</p>
        </div>

        <div class="pkg-grid" style="display:grid;gap:20px;">
            @foreach($featuredPackages as $pkg)
            @php
                $isFree    = $pkg->slug === 'free-trial';
                $isMonthly = $pkg->slug === 'monthly';
            @endphp
            <div style="background:#18181b;border-radius:16px;padding:28px 24px;position:relative;border:1px solid #27272a;display:flex;flex-direction:column;transition:border-color 0.2s,box-shadow 0.2s;" onmouseover="this.style.borderColor='#3f3f46';this.style.boxShadow='0 8px 32px rgba(0,0,0,0.3)'" onmouseout="this.style.borderColor='#27272a';this.style.boxShadow='none'">

                {{-- Badge --}}
                @if($isFree)
                <div style="position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:#22c55e;color:#fff;padding:3px 16px;border-radius:20px;font-size:10.5px;font-weight:700;letter-spacing:0.5px;white-space:nowrap;box-shadow:0 2px 8px rgba(34,197,94,0.35);">Starts Free</div>
                @elseif($isMonthly)
                <div style="position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:#f59e0b;color:#09090b;padding:3px 16px;border-radius:20px;font-size:10.5px;font-weight:700;letter-spacing:0.5px;white-space:nowrap;box-shadow:0 2px 8px rgba(245,158,11,0.35);">Starts Free</div>
                @endif

                <div style="margin-top:{{ ($isFree || $isMonthly) ? '10px' : '0' }};">
                    <div style="font-size:12px;color:#71717a;margin-bottom:4px;letter-spacing:0.3px;">{{ $pkg->duration }} Access</div>
                    <div style="font-size:1.05rem;font-weight:800;color:#fafafa;margin-bottom:20px;letter-spacing:-0.1px;">{{ $pkg->name }}</div>
                </div>

                <div style="margin-bottom:20px;">
                    @if($isFree)
                    <div style="font-size:2.8rem;font-weight:900;color:#fafafa;line-height:1;letter-spacing:-1px;">FREE</div>
                    <div style="font-size:12px;color:#71717a;margin-top:6px;">No credit card needed</div>
                    @else
                    <div style="font-size:2.4rem;font-weight:900;color:#fafafa;line-height:1;letter-spacing:-1px;">
                        <sup style="font-size:1rem;color:#a1a1aa;vertical-align:top;margin-top:8px;font-weight:600;">$</sup>{{ number_format($pkg->price, 2) }}
                    </div>
                    @endif
                </div>

                <ul style="list-style:none;text-align:left;margin:0 0 24px;padding:0;flex:1;">
                    @foreach(array_slice($pkg->features ?? [], 0, 5) as $feature)
                    <li style="padding:7px 0;font-size:13px;color:#a1a1aa;border-bottom:1px solid #27272a;display:flex;align-items:center;gap:8px;">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" style="flex-shrink:0;"><circle cx="7" cy="7" r="7" fill="rgba(74,222,128,0.15)"/><path d="M4 7l2 2 4-4" stroke="#4ade80" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        {{ $feature }}
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('join') }}" style="display:block;width:100%;padding:11px;border-radius:10px;font-weight:700;font-size:14px;text-decoration:none;text-align:center;letter-spacing:0.1px;{{ $isFree ? 'border:1.5px solid #22c55e;color:#22c55e;background:transparent;' : 'border:1.5px solid #22b8b8;color:#22b8b8;background:transparent;' }}" onmouseover="this.style.background='{{ $isFree ? 'rgba(34,197,94,0.1)' : 'rgba(34,184,184,0.1)' }}'" onmouseout="this.style.background='transparent'">
                    {{ $isFree ? 'Start Free Trial' : 'Get Started' }}
                </a>
            </div>
            @endforeach
        </div>

        <div style="text-align:center;margin-top:20px;">
            <a href="{{ route('join') }}" style="color:#71717a;font-size:14px;text-decoration:none;transition:color 0.15s;" onmouseover="this.style.color='#f59e0b'" onmouseout="this.style.color='#71717a'">View all packages & pricing →</a>
        </div>
    </div>
</div>

@push('scripts')
<style>
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
</style>
<script>
function scrollArticles(dir) {
    const track = document.getElementById('articlesTrack');
    if (!track) return;
    track.scrollBy({ left: dir * 340, behavior: 'smooth' });
}
</script>
@endpush

@endsection
