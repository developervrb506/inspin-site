@extends('layouts.subscriber')
@section('title', 'My Dashboard - INSPIN')
@section('page-title', 'Dashboard')

@push('styles')
<style>
.dash-top { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:22px; }
@media(max-width:1100px){ .dash-top { grid-template-columns:repeat(2,1fr); } }
@media(max-width:560px) { .dash-top { grid-template-columns:1fr 1fr; } }

.dash-mid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:22px; }
@media(max-width:900px){ .dash-mid { grid-template-columns:1fr; } }

.dash-bottom { display:grid; grid-template-columns:2fr 1fr; gap:16px; }
@media(max-width:900px){ .dash-bottom { grid-template-columns:1fr; } }

.kpi { background:#141414; border:1px solid rgba(255,252,238,.07); border-radius:12px; padding:16px 18px; }
.kpi-label { font-size:9px; text-transform:uppercase; letter-spacing:.6px; color:#6e6e6e; font-weight:700; margin-bottom:8px; }
.kpi-value { font-family:'Clash Display',sans-serif; font-size:1.8rem; font-weight:600; line-height:1; }
.kpi-sub { font-size:11px; color:#6e6e6e; margin-top:6px; }

.panel { background:#141414; border:1px solid rgba(255,252,238,.07); border-radius:12px; overflow:hidden; }
.panel-header { padding:14px 18px; border-bottom:1px solid rgba(255,252,238,.07); display:flex; align-items:center; justify-content:space-between; }
.panel-title { font-family:'Clash Display',sans-serif; font-size:.9rem; font-weight:500; color:#FFFCEE; }
.panel-link { font-size:11px; color:#FDB515; text-decoration:none; font-weight:600; }
.panel-link:hover { opacity:.8; }

.pick-row { padding:11px 18px; border-bottom:1px solid rgba(255,252,238,.04); display:flex; align-items:center; gap:12px; transition:background .12s; }
.pick-row:last-child { border-bottom:none; }
.pick-row:hover { background:rgba(255,252,238,.02); }

.sport-chip { font-size:9px; font-weight:800; padding:2px 7px; border-radius:4px; text-transform:uppercase; flex-shrink:0; }
.result-badge { font-size:10px; font-weight:700; padding:2px 8px; border-radius:10px; flex-shrink:0; }
</style>
@endpush

@section('content')
@php
    $user = auth()->user();
    $total = $wins + $losses + $pushes;
    $wr    = $total > 0 ? round(($wins/$total)*100,1) : 0;
    $sportEmojis = ['MLB'=>'⚾','NFL'=>'🏈','NBA'=>'🏀','NHL'=>'🏒','NCAAF'=>'🏈','NCAAB'=>'🏀'];
@endphp

{{-- Welcome --}}
<div style="margin-bottom:22px;display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:10px;">
    <div>
        <h1 style="font-family:'Clash Display',sans-serif;font-size:1.6rem;font-weight:500;color:#FFFCEE;line-height:1.2;">Welcome back, {{ explode(' ', $user->name)[0] }} 👋</h1>
        <p style="font-size:13px;color:#6e6e6e;margin-top:4px;">
            {{ now()->format('l, F j, Y') }}
            @if($sub && !$sub->isExpired())
            · <span style="color:#FDB515;">{{ $sub->daysRemaining() }} days left</span> on {{ $sub->packageName() }}
            @endif
        </p>
    </div>
    @if($sub && $sub->status_note === 'extended')
    <div style="background:rgba(99,102,241,.1);border:1px solid rgba(99,102,241,.25);border-radius:8px;padding:8px 14px;font-size:12px;color:#a5b4fc;">
        ⟳ Package extended (negative units)
    </div>
    @endif
</div>

@if(!$sub)
{{-- No subscription --}}
<div style="background:#141414;border:1px solid rgba(253,181,21,.15);border-radius:14px;padding:48px;text-align:center;">
    <div style="font-size:3rem;margin-bottom:16px;">📦</div>
    <h2 style="font-family:'Clash Display',sans-serif;font-size:1.3rem;font-weight:500;color:#FFFCEE;margin-bottom:8px;">No Active Package</h2>
    <p style="color:#6e6e6e;margin-bottom:24px;font-size:13px;">Subscribe to start accessing expert picks and analysis.</p>
    <a href="/subscriber/packages" style="display:inline-block;padding:12px 32px;background:#FDB515;color:#171818;border-radius:50px;font-weight:700;text-decoration:none;">View Packages →</a>
</div>
@else

{{-- ── Row 1: KPI cards ── --}}
<div class="dash-top">
    {{-- Package --}}
    <div class="kpi" style="border-color:rgba(253,181,21,.15);">
        <div class="kpi-label">My Package</div>
        <div style="font-family:'Clash Display',sans-serif;font-size:1.1rem;font-weight:500;color:#FFFCEE;margin-bottom:4px;">{{ $sub->packageName() }}</div>
        <div style="font-size:13px;color:#FDB515;font-weight:700;margin-bottom:8px;">{{ str_repeat('★', min($sub->max_stars,5)) }}{{ $sub->max_stars > 5 ? '+' : '' }} Access</div>
        <div style="height:3px;background:#1e1e1e;border-radius:2px;overflow:hidden;">
            <div style="width:{{ min(($sub->max_stars/10)*100, 100) }}%;height:100%;background:#FDB515;border-radius:2px;"></div>
        </div>
        <div class="kpi-sub">
            @if($sub->isExpired() && $sub->status_note !== 'extended')
                <span style="color:#ef4444;">Expired</span>
            @else
                Expires {{ $sub->expires_at->format('M d, Y') }}
            @endif
        </div>
    </div>

    {{-- Units --}}
    @php $u = (float)$sub->units_total; @endphp
    <div class="kpi">
        <div class="kpi-label">Total Units</div>
        <div class="kpi-value" style="color:{{ $u >= 0 ? '#00D15B' : '#ef4444' }};">{{ $u >= 0 ? '+' : '' }}{{ number_format($u,2) }}</div>
        <div class="kpi-sub">{{ $u >= 0 ? '✓ Profitable since sign-up' : '⚠ Currently at a deficit' }}</div>
    </div>

    {{-- Win Rate --}}
    <div class="kpi">
        <div class="kpi-label">Win Rate</div>
        <div class="kpi-value" style="color:{{ $wr >= 55 ? '#00D15B' : ($wr >= 45 ? '#FDB515' : ($total > 0 ? '#ef4444' : '#6e6e6e')) }};">{{ $wr }}%</div>
        <div class="kpi-sub">{{ $wins }}W · {{ $losses }}L{{ $pushes > 0 ? ' · '.$pushes.'P' : '' }} · {{ $total }} graded</div>
    </div>

    {{-- Active Picks Today --}}
    <div class="kpi">
        <div class="kpi-label">Active Picks</div>
        <div class="kpi-value" style="color:#FFFCEE;">{{ $activePicks->count() }}</div>
        <div class="kpi-sub">{{ $picksSinceStart }} total picks since sign-up</div>
        @if($activePicks->count() > 0)
        <a href="/subscriber/picks" style="display:inline-block;margin-top:8px;font-size:11px;color:#FDB515;text-decoration:none;font-weight:600;">View picks →</a>
        @endif
    </div>
</div>

{{-- ── Row 2: Active Picks + Performance by Sport ── --}}
<div class="dash-mid">
    {{-- Today's Active Picks --}}
    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">🔥 Active Picks</span>
            <a href="/subscriber/picks" class="panel-link">View all →</a>
        </div>
        @if($activePicks->count() > 0)
        @foreach($activePicks as $pick)
        @php
            $rawT    = $pick->game_time ? (string)$pick->game_time : '00:00:00';
            $timeStr = strlen($rawT) === 5 ? $rawT.':00' : substr($rawT, 0, 8);
            $gStart  = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pick->game_date->format('Y-m-d').' '.$timeStr, 'America/New_York');
            $pNow    = \Carbon\Carbon::now('America/New_York');
            $pStatus = $pNow->gte($gStart) ? 'Started' : 'Active';
            $scColor = ['Started'=>'#ef4444','Active'=>'#00D15B'];
            $spColors= ['MLB'=>['#22c55e','rgba(34,197,94,.12)'],'NFL'=>['#3b82f6','rgba(59,130,246,.12)'],'NBA'=>['#ef4444','rgba(220,38,38,.12)'],'NHL'=>['#a855f7','rgba(168,85,247,.12)']];
            $sc = $spColors[$pick->sport] ?? ['#FDB515','rgba(253,181,21,.1)'];
        @endphp
        <div class="pick-row">
            <span class="sport-chip" style="background:{{ $sc[1] }};color:{{ $sc[0] }};">{{ $pick->sport }}</span>
            <div style="flex:1;min-width:0;">
                <div style="font-size:13px;font-weight:600;color:#FFFCEE;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $pick->team1_name }} vs {{ $pick->team2_name }}</div>
                <div style="font-size:11px;color:#6e6e6e;">{{ $pick->game_date->format('M d') }}{{ $pick->game_time ? ' · '.\Carbon\Carbon::parse($pick->game_time)->format('g:i A').' ET' : '' }}</div>
            </div>
            <div style="text-align:right;flex-shrink:0;">
                @php $dSS=['Started'=>'background:rgba(239,68,68,.15);border:1px solid #ef4444;color:#ef4444;','Active'=>'background:rgba(0,209,91,.15);border:1px solid #00D15B;color:#00D15B;']; @endphp
                <span style="{{ $dSS[$pStatus] ?? '' }}font-size:12px;font-weight:800;padding:2px 8px;border-radius:20px;display:inline-block;">{{ $pStatus }}</span>
                <div style="font-size:12px;color:#FDB515;">{{ str_repeat('★',(int)$pick->stars) }}</div>
            </div>
        </div>
        @endforeach
        @else
        <div style="padding:32px;text-align:center;color:#4a4a4a;">
            <div style="font-size:2rem;margin-bottom:10px;">📋</div>
            <p style="font-size:13px;color:#6e6e6e;">No active picks right now.<br>Check back soon!</p>
        </div>
        @endif
    </div>

    {{-- Performance by Sport --}}
    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">📊 By Sport</span>
            <a href="/subscriber/trends" class="panel-link">Full trends →</a>
        </div>
        @if(count($sportRecord) > 0)
        @foreach($sportRecord as $sport => $rec)
        @php
            $stTotal = $rec['wins'] + $rec['losses'] + $rec['pushes'];
            $stWr = $stTotal > 0 ? round(($rec['wins']/$stTotal)*100) : 0;
        @endphp
        <div class="pick-row">
            <span style="font-size:16px;flex-shrink:0;">{{ $sportEmojis[$sport] ?? '🏅' }}</span>
            <div style="flex:1;">
                <div style="font-size:12px;font-weight:700;color:#FFFCEE;margin-bottom:3px;">{{ $sport }}</div>
                <div style="height:4px;background:#1e1e1e;border-radius:2px;overflow:hidden;">
                    <div style="width:{{ $stWr }}%;height:100%;background:{{ $stWr>=55?'#00D15B':($stWr>=45?'#FDB515':'#ef4444') }};border-radius:2px;"></div>
                </div>
            </div>
            <div style="text-align:right;flex-shrink:0;">
                <div style="font-size:12px;font-weight:700;color:{{ $rec['units']>=0?'#00D15B':'#ef4444' }};">{{ $rec['units']>=0?'+':'' }}{{ number_format($rec['units'],1) }}u</div>
                <div style="font-size:10px;color:#6e6e6e;">{{ $rec['wins'] }}-{{ $rec['losses'] }}</div>
            </div>
        </div>
        @endforeach
        @else
        <div style="padding:32px;text-align:center;">
            <div style="font-size:2rem;margin-bottom:10px;">📈</div>
            <p style="font-size:12px;color:#6e6e6e;">No graded picks yet.<br>Stats appear once picks are graded.</p>
        </div>
        @endif
    </div>
</div>

{{-- ── Row 3: Recent picks history + Latest articles ── --}}
<div class="dash-bottom">
    {{-- Recent picks history --}}
    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">📋 Pick History</span>
            <a href="/subscriber/picks" class="panel-link">See all →</a>
        </div>
        @if($recentPicks->count() > 0)
        @foreach($recentPicks as $pick)
        @php
            $isGraded = in_array($pick->result, ['win','loss','push']);
            $rColors  = ['win'=>['#00D15B','rgba(0,209,91,.1)'],'loss'=>['#ef4444','rgba(239,68,68,.1)'],'push'=>['#FDB515','rgba(253,181,21,.1)'],'pending'=>['#6e6e6e','rgba(100,100,100,.08)']];
            $rc = $rColors[$pick->result] ?? $rColors['pending'];
            $spC = $spColors[$pick->sport] ?? ['#FDB515','rgba(253,181,21,.1)'];
        @endphp
        <div class="pick-row">
            <span class="sport-chip" style="background:{{ $spC[1] }};color:{{ $spC[0] }};">{{ $pick->sport }}</span>
            <div style="flex:1;min-width:0;">
                <div style="font-size:12.5px;font-weight:600;color:#FFFCEE;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $pick->team1_name }} vs {{ $pick->team2_name }}</div>
                <div style="font-size:11px;color:#6e6e6e;">{{ $pick->game_date->format('M d') }} · {{ str_repeat('★',(int)min($pick->stars,5)) }}</div>
            </div>
            <div style="text-align:right;flex-shrink:0;">
                @if($isGraded)
                <span class="result-badge" style="background:{{ $rc[1] }};color:{{ $rc[0] }};border:1px solid {{ $rc[0] }}44;">{{ strtoupper($pick->result) }}</span>
                @if($pick->units_result !== null)
                <div style="font-size:11px;font-weight:700;color:{{ $rc[0] }};margin-top:3px;">{{ $pick->units_result >= 0 ? '+' : '' }}{{ $pick->units_result }}u</div>
                @endif
                @else
                <span class="result-badge" style="background:rgba(100,100,100,.08);color:#6e6e6e;border:1px solid rgba(255,252,238,.06);">PENDING</span>
                @endif
            </div>
        </div>
        @endforeach
        @else
        <div style="padding:32px;text-align:center;">
            <div style="font-size:2rem;margin-bottom:10px;">🏅</div>
            <p style="font-size:12px;color:#6e6e6e;">No picks yet since your sign-up date.</p>
        </div>
        @endif
    </div>

    {{-- Latest articles --}}
    <div class="panel">
        <div class="panel-header">
            <span class="panel-title">📰 Latest Articles</span>
            <a href="/subscriber/articles" class="panel-link">All articles →</a>
        </div>
        @if($latestArticles->count() > 0)
        @foreach($latestArticles as $art)
        @php $artSp = strtolower($art->sport??''); $artTc = $artSp==='mlb'?'#4ade80':($artSp==='nba'?'#f87171':($artSp==='nfl'?'#93c5fd':'#FDB515')); @endphp
        <a href="/subscriber/articles/{{ $art->slug }}" style="text-decoration:none;">
            <div class="pick-row" style="gap:10px;">
                @if($art->featured_image)
                <img src="{{ asset('storage/'.$art->featured_image) }}" style="width:44px;height:44px;object-fit:cover;border-radius:6px;flex-shrink:0;">
                @else
                <div style="width:44px;height:44px;background:#212121;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">🏅</div>
                @endif
                <div style="flex:1;min-width:0;">
                    <div style="font-size:12px;font-weight:600;color:#FFFCEE;line-height:1.35;margin-bottom:3px;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">{{ $art->title }}</div>
                    <div style="font-size:10px;color:#4a4a4a;">{{ $art->published_at?->format('M d') }} · <span style="color:{{ $artTc }};">{{ $art->sport }}</span></div>
                </div>
            </div>
        </a>
        @endforeach
        @else
        <div style="padding:32px;text-align:center;">
            <p style="font-size:12px;color:#6e6e6e;">No articles yet.</p>
        </div>
        @endif
    </div>
</div>

{{-- Upgrade CTA --}}
@if($sub->max_stars < 10)
<div style="margin-top:18px;background:rgba(253,181,21,.05);border:1px solid rgba(253,181,21,.12);border-radius:12px;padding:16px 22px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;">
    <div>
        <div style="font-size:13px;font-weight:700;color:#FFFCEE;margin-bottom:3px;">🚀 Unlock More Picks</div>
        <div style="font-size:12px;color:#6e6e6e;">Your package includes up to <strong style="color:#FDB515;">{{ $sub->max_stars }}★</strong> picks. Upgrade to access higher-confidence plays.</div>
    </div>
    <a href="/subscriber/packages" style="display:inline-block;padding:10px 22px;background:#FDB515;color:#171818;border-radius:50px;font-weight:700;text-decoration:none;font-size:13px;white-space:nowrap;">Upgrade Package</a>
</div>
@endif

@endif
@endsection
