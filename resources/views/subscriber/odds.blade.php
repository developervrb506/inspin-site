@extends('layouts.subscriber')
@section('title', 'Live Odds - INSPIN')
@section('page-title', 'Live Odds')

@section('content')
<div style="display:flex;flex-direction:column;gap:10px;">
    @forelse($consensus as $game)
    @php
        $sportColors = ['NFL'=>['#3b82f6','rgba(59,130,246,.08)'],'NBA'=>['#ef4444','rgba(220,38,38,.08)'],'MLB'=>['#22c55e','rgba(34,197,94,.08)'],'NHL'=>['#a855f7','rgba(168,85,247,.08)']];
        $sc = $sportColors[$game->league] ?? ['#FDB515','rgba(253,181,21,.08)'];
        $mlA = $game->moneyline_away ?? '—'; $mlH = $game->moneyline_home ?? '—';
        $mlAColor = (is_numeric(str_replace(['+'],'',$mlA)) && (int)str_replace('+','',$mlA) > 0) ? '#FDB515' : '#FFFCEE';
        $mlHColor = (is_numeric(str_replace(['+'],'',$mlH)) && (int)str_replace('+','',$mlH) > 0) ? '#FDB515' : '#FFFCEE';
    @endphp
    <div style="background:#1a1a1a;border:1px solid rgba(255,252,238,.07);border-radius:10px;overflow:hidden;transition:border-color .2s;" onmouseover="this.style.borderColor='rgba(253,181,21,.2)'" onmouseout="this.style.borderColor='rgba(255,252,238,.07)'">
        <div style="padding:10px 16px;border-bottom:1px solid rgba(255,252,238,.05);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:{{ $sc[1] }};color:{{ $sc[0] }};border:1px solid {{ $sc[0] }}44;padding:2px 8px;border-radius:6px;font-size:10px;font-weight:700;">{{ $game->league }}</span>
                <span style="font-size:13px;font-weight:600;color:#FFFCEE;">{{ $game->away_team }} @ {{ $game->home_team }}</span>
            </div>
            <span style="font-size:11px;color:#6e6e6e;">{{ $game->game_date?->format('M d, g:i A') ?? 'TBD' }} ET</span>
        </div>
        <div style="padding:12px 16px;display:grid;grid-template-columns:1fr 1fr 1fr 1fr;gap:16px;">
            <div>
                <div style="font-size:10px;color:#6e6e6e;font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Moneyline</div>
                <div style="font-size:13px;font-weight:600;color:{{ $mlAColor }}">{{ $mlA }}</div>
                <div style="font-size:13px;font-weight:600;color:{{ $mlHColor }}">{{ $mlH }}</div>
            </div>
            <div>
                <div style="font-size:10px;color:#6e6e6e;font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Spread</div>
                <div style="font-size:13px;color:#9a9a9a;">{{ $game->spread_away ?? '—' }}</div>
                <div style="font-size:13px;color:#9a9a9a;">{{ $game->spread_home ?? '—' }}</div>
            </div>
            <div>
                <div style="font-size:10px;color:#6e6e6e;font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Total</div>
                <div style="font-size:13px;color:#00D15B;font-weight:600;">{{ $game->total_over ?? '—' }}</div>
                <div style="font-size:13px;color:#ef4444;font-weight:600;">{{ $game->total_under ?? '—' }}</div>
            </div>
            <div>
                <div style="font-size:10px;color:#6e6e6e;font-weight:700;text-transform:uppercase;letter-spacing:.4px;margin-bottom:6px;">Game Time</div>
                <div style="font-size:12px;color:#9a9a9a;">{{ $game->game_date?->format('M d') ?? 'TBD' }}</div>
                <div style="font-size:12px;color:#9a9a9a;">{{ $game->game_date && $game->game_date->format('g:i A') !== '12:00 AM' ? $game->game_date->format('g:i A').' ET' : 'TBD ET' }}</div>
            </div>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:48px 0;">
        <div style="font-size:2.5rem;margin-bottom:12px;">📊</div>
        <p style="color:#6e6e6e;">No odds data available.</p>
    </div>
    @endforelse
</div>
@endsection
