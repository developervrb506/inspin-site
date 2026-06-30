@extends('layouts.subscriber')
@section('title', 'Live Odds - INSPIN')
@section('page-title', 'Live Odds')

@push('styles')
<style>
    @keyframes fadeUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    @keyframes pulse  { 0%,100%{opacity:1} 50%{opacity:.4} }

    .odds-live-dot {
        width:7px; height:7px; border-radius:50%; background:#22c55e;
        display:inline-block; margin-right:5px;
        animation:pulse 1.8s ease-in-out infinite;
        box-shadow:0 0 6px rgba(34,197,94,.6);
    }
    .odds-header {
        display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap;
        gap:12px; margin-bottom:18px;
        animation:fadeUp .35s ease both;
    }
    .odds-sport-tabs {
        display:flex; gap:6px; flex-wrap:wrap;
        animation:fadeUp .35s ease .05s both;
        margin-bottom:16px;
    }
    .sport-tab {
        padding:5px 14px; border-radius:20px; font-size:11.5px; font-weight:700;
        border:1.5px solid rgba(255,252,238,.08); color:#555; background:transparent;
        cursor:pointer; text-decoration:none; transition:border-color .15s, color .15s, background .15s;
        font-family:'DM Sans',sans-serif;
    }
    .sport-tab:hover        { border-color:rgba(253,181,21,.3); color:#FDB515; }
    .sport-tab.active       { background:rgba(253,181,21,.1); border-color:rgba(253,181,21,.3); color:#FDB515; }
    .sport-tab.nfl.active   { background:rgba(59,130,246,.1); border-color:rgba(59,130,246,.3); color:#60a5fa; }
    .sport-tab.nba.active   { background:rgba(239,68,68,.1); border-color:rgba(239,68,68,.3); color:#f87171; }
    .sport-tab.mlb.active   { background:rgba(34,197,94,.1); border-color:rgba(34,197,94,.3); color:#4ade80; }
    .sport-tab.nhl.active   { background:rgba(168,85,247,.1); border-color:rgba(168,85,247,.3); color:#c084fc; }

    .odds-card {
        background:#141414; border:1px solid rgba(255,252,238,.07);
        border-radius:13px; overflow:hidden; margin-bottom:10px;
        transition:border-color .2s;
        animation:fadeUp .35s ease both;
    }
    .odds-card:hover { border-color:rgba(255,252,238,.12); }
    .odds-card:nth-child(1){animation-delay:.04s} .odds-card:nth-child(2){animation-delay:.08s}
    .odds-card:nth-child(3){animation-delay:.12s} .odds-card:nth-child(4){animation-delay:.16s}
    .odds-card:nth-child(5){animation-delay:.20s} .odds-card:nth-child(6){animation-delay:.24s}

    .odds-card-head {
        padding:12px 18px;
        border-bottom:1px solid rgba(255,255,255,.06);
        display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;
    }
    .odds-league {
        padding:2px 10px; border-radius:6px;
        font-size:10px; font-weight:700; letter-spacing:.3px;
    }
    .odds-matchup { font-size:13.5px; font-weight:600; color:#FFFCEE; }
    .odds-vs      { color:rgba(255,255,255,.25); font-size:11px; margin:0 6px; }
    .odds-time    { font-size:11.5px; color:#444; }

    .odds-grid {
        display:grid; grid-template-columns:repeat(4,1fr);
        padding:14px 18px; gap:16px;
    }
    @media(max-width:600px){ .odds-grid { grid-template-columns:repeat(2,1fr); gap:12px; } }

    .odds-col-label {
        font-size:9px; color:#3a3a3a; text-transform:uppercase;
        letter-spacing:.5px; font-weight:700; margin-bottom:7px;
    }
    .odds-val  { font-size:13.5px; font-weight:600; color:#FFFCEE; margin-bottom:3px; line-height:1.3; }
    .odds-val2 { font-size:13.5px; font-weight:600; color:#FFFCEE; line-height:1.3; }
    .odds-pos  { color:#FDB515; }
    .odds-over { color:#22c55e; }
    .odds-under{ color:#ef4444; }
    .odds-muted{ color:#444; }

    .odds-empty {
        text-align:center; padding:64px 24px;
        animation:fadeUp .4s ease both;
    }
</style>
@endpush

@section('content')

@php
$sportColors = [
    'NFL' => ['rgba(59,130,246,.1)', 'rgba(59,130,246,.25)', '#60a5fa'],
    'NBA' => ['rgba(239,68,68,.1)',   'rgba(239,68,68,.25)',  '#f87171'],
    'MLB' => ['rgba(34,197,94,.1)',   'rgba(34,197,94,.25)',  '#4ade80'],
    'NHL' => ['rgba(168,85,247,.1)',  'rgba(168,85,247,.25)', '#c084fc'],
];
$sport  = request('sport');
$games  = $consensus;
$sports = $games->pluck('league')->unique()->sort()->values();
@endphp

{{-- Header --}}
<div class="odds-header">
    <div style="display:flex;align-items:center;gap:8px;">
        <span class="odds-live-dot"></span>
        <span style="font-size:12px;color:#22c55e;font-weight:700;">Live Odds</span>
        <span style="font-size:12px;color:#3a3a3a;">· Updated automatically</span>
    </div>
    <span style="font-size:11.5px;color:#3a3a3a;">{{ $games->count() }} game{{ $games->count() !== 1 ? 's' : '' }} available</span>
</div>

{{-- Sport filter tabs --}}
<div class="odds-sport-tabs">
    <a href="{{ route('subscriber.odds') }}"
       class="sport-tab {{ !$sport ? 'active' : '' }}">All Sports</a>
    @foreach($sports as $s)
    <a href="{{ route('subscriber.odds', ['sport' => $s]) }}"
       class="sport-tab {{ strtolower($s) }} {{ $sport === $s ? 'active' : '' }}">{{ $s }}</a>
    @endforeach
</div>

{{-- Games --}}
@php
$filtered = $sport ? $games->where('league', $sport)->values() : $games;
@endphp

@if($filtered->isEmpty())
<div class="odds-empty">
    <div style="font-size:2.5rem;margin-bottom:12px;">⚡</div>
    <div style="font-size:15px;font-weight:700;color:#FFFCEE;margin-bottom:6px;">No games right now</div>
    <div style="font-size:13px;color:#3a3a3a;line-height:1.65;">
        {{ $sport ? "No $sport games are currently listed." : "No games are available at the moment." }}<br>
        Check back closer to game time for updated lines.
    </div>
</div>
@else
<div>
    @foreach($filtered as $game)
    @php
        $sc  = $sportColors[$game->league] ?? ['rgba(253,181,21,.1)', 'rgba(253,181,21,.25)', '#FDB515'];
        $mlA = $game->moneyline_away ?? '—';
        $mlH = $game->moneyline_home ?? '—';
        $mlAPosColor = (is_numeric($v = str_replace('+','',$mlA)) && (int)$v > 0) ? 'odds-pos' : '';
        $mlHPosColor = (is_numeric($v = str_replace('+','',$mlH)) && (int)$v > 0) ? 'odds-pos' : '';
        $gameTime = $game->game_date?->format('g:i A') !== '12:00 AM' ? $game->game_date?->format('g:i A').' ET' : 'TBD';
        $gameDate = $game->game_date?->format('M d, Y') ?? 'TBD';
    @endphp
    <div class="odds-card">
        <div class="odds-card-head">
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <span class="odds-league" style="background:{{ $sc[0] }};border:1px solid {{ $sc[1] }};color:{{ $sc[2] }};">{{ $game->league }}</span>
                <span class="odds-matchup">
                    {{ $game->away_team }}
                    <span class="odds-vs">@</span>
                    {{ $game->home_team }}
                </span>
            </div>
            <span class="odds-time">{{ $gameDate }} · {{ $gameTime }}</span>
        </div>
        <div class="odds-grid">
            {{-- Moneyline --}}
            <div>
                <div class="odds-col-label">Moneyline</div>
                <div class="odds-val {{ $mlAPosColor }}">{{ $mlA }}</div>
                <div class="odds-val2 {{ $mlHPosColor }}">{{ $mlH }}</div>
            </div>
            {{-- Spread --}}
            <div>
                <div class="odds-col-label">Spread</div>
                <div class="odds-val odds-muted">{{ $game->spread_away ?? '—' }}</div>
                <div class="odds-val2 odds-muted">{{ $game->spread_home ?? '—' }}</div>
            </div>
            {{-- Total --}}
            <div>
                <div class="odds-col-label">Total</div>
                <div class="odds-val odds-over">{{ $game->total_over ?? '—' }}</div>
                <div class="odds-val2 odds-under">{{ $game->total_under ?? '—' }}</div>
            </div>
            {{-- Teams --}}
            <div>
                <div class="odds-col-label">Teams</div>
                <div class="odds-val" style="font-size:12px;color:#555;">{{ $game->away_team }}</div>
                <div class="odds-val2" style="font-size:12px;color:#555;">{{ $game->home_team }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

@endsection
