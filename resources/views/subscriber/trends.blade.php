@extends('layouts.subscriber')
@section('title', 'Betting Trends - INSPIN')
@section('page-title', 'Betting Trends')

@push('styles')
<style>
.sport-cards { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:28px; }
@media(max-width:900px){ .sport-cards { grid-template-columns:repeat(2,1fr); } }
@media(max-width:560px){ .sport-cards { grid-template-columns:1fr; } }

.sport-card {
    background:#141414;
    border:1px solid rgba(255,252,238,.07);
    border-radius:12px; padding:18px 20px;
    transition:border-color .2s, box-shadow .2s;
    cursor:pointer;
}
.sport-card:hover { border-color:rgba(255,252,238,.15); box-shadow:0 4px 20px rgba(0,0,0,.4); }
.sport-card.hot { border-color:rgba(0,209,91,.25); box-shadow:0 0 20px rgba(0,209,91,.06); }

.sc-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; }
.sc-sport { font-family:'Clash Display',sans-serif; font-size:1.1rem; font-weight:500; color:#FFFCEE; }
.sc-badge { font-size:10px; font-weight:700; padding:3px 10px; border-radius:20px; }
.sc-stats { display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px; }
.sc-stat-label { font-size:9px; text-transform:uppercase; letter-spacing:.5px; color:#6e6e6e; font-weight:700; margin-bottom:3px; }
.sc-stat-value { font-size:1.1rem; font-family:'Clash Display',sans-serif; font-weight:600; line-height:1; }

.trends-table { width:100%; border-collapse:collapse; }
.trends-table thead tr { background:#0d0d0d; }
.trends-table thead th { padding:10px 14px; text-align:left; font-size:9px; text-transform:uppercase; letter-spacing:.6px; color:#6e6e6e; font-weight:700; white-space:nowrap; border-bottom:1px solid rgba(255,252,238,.07); }
.trends-table tbody tr { border-bottom:1px solid rgba(255,252,238,.04); transition:background .12s; }
.trends-table tbody tr:hover { background:rgba(255,252,238,.02); }
.trends-table tbody td { padding:10px 14px; font-size:13px; white-space:nowrap; }
</style>
@endpush

@section('content')
@php
    $sportColors = [
        'NFL'  => ['#3b82f6', 'rgba(59,130,246,.1)'],
        'NBA'  => ['#ef4444', 'rgba(220,38,38,.1)'],
        'MLB'  => ['#22c55e', 'rgba(34,197,94,.1)'],
        'NHL'  => ['#a855f7', 'rgba(168,85,247,.1)'],
        'NCAAF'=> ['#f97316', 'rgba(249,115,22,.1)'],
        'NCAAB'=> ['#f59e0b', 'rgba(245,158,11,.1)'],
    ];

    // Build sport summary from streaks (use last_30_picks period)
    $sportSummary = [];
    foreach($streaks as $sport => $periods) {
        $best = $periods['last_30_picks'] ?? $periods['last_10_picks'] ?? array_values($periods)[0] ?? null;
        if($best) $sportSummary[$sport] = $best;
    }
@endphp

{{-- Hot Streaks banner (only if any exist) --}}
@if(!empty($hotStreaks) && count($hotStreaks) > 0)
<div style="background:linear-gradient(135deg,rgba(0,209,91,.08),rgba(0,0,0,0));border:1px solid rgba(0,209,91,.2);border-radius:12px;padding:16px 20px;margin-bottom:24px;display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
    <div style="font-size:1.5rem;">🔥</div>
    <div style="flex:1;">
        <div style="font-size:12px;font-weight:700;color:#00D15B;margin-bottom:4px;text-transform:uppercase;letter-spacing:.4px;">Active Hot Streaks</div>
        <div style="display:flex;gap:12px;flex-wrap:wrap;">
            @foreach($hotStreaks as $hot)
            <span style="background:rgba(0,209,91,.1);border:1px solid rgba(0,209,91,.3);color:#00D15B;padding:4px 12px;border-radius:20px;font-size:12px;font-weight:700;">
                {{ $hot['sport'] }} · {{ $hot['streak'] }}W · {{ $hot['win_rate'] }}% · {{ $hot['units']>=0?'+':'' }}{{ number_format($hot['units'],1) }}u
            </span>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- Sport Summary Cards --}}
<h2 style="font-family:'Clash Display',sans-serif;font-size:.95rem;font-weight:500;color:#FFFCEE;margin-bottom:14px;">Performance by Sport <span style="font-size:11px;color:#6e6e6e;font-weight:400;">(last 30 picks)</span></h2>
<div class="sport-cards">
    @foreach($sportSummary as $sport => $data)
    @php
        $colors = $sportColors[$sport] ?? ['#9a9a9a','rgba(255,255,255,.05)'];
        $isHot  = $data['is_hot'] ?? false;
        $wr     = $data['win_rate'] ?? 0;
        $units  = $data['total_units'] ?? 0;
        $streak = $data['current_streak'] ?? 0;
        $wins   = $data['total_wins'] ?? 0;
        $losses = $data['total_losses'] ?? 0;
        $pushes = $data['total_pushes'] ?? 0;
        $total  = $wins + $losses + $pushes;
    @endphp
    <div class="sport-card {{ $isHot ? 'hot' : '' }}">
        <div class="sc-header">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:32px;height:32px;border-radius:8px;background:{{ $colors[1] }};border:1px solid {{ $colors[0] }}44;display:flex;align-items:center;justify-content:center;">
                    <span style="font-size:13px;font-weight:800;color:{{ $colors[0] }};">{{ substr($sport,0,2) }}</span>
                </div>
                <span class="sc-sport">{{ $sport }}</span>
            </div>
            @if($isHot)
            <span class="sc-badge" style="background:rgba(0,209,91,.12);color:#00D15B;border:1px solid #00D15B;">🔥 HOT</span>
            @elseif($streak > 0)
            <span class="sc-badge" style="background:rgba(253,181,21,.1);color:#FDB515;border:1px solid rgba(253,181,21,.3);">{{ $streak }}W Streak</span>
            @else
            <span class="sc-badge" style="background:rgba(255,252,238,.04);color:#4a4a4a;border:1px solid rgba(255,252,238,.06);">{{ $total > 0 ? $total.' picks' : 'No data' }}</span>
            @endif
        </div>

        <div class="sc-stats">
            <div>
                <div class="sc-stat-label">Win Rate</div>
                <div class="sc-stat-value" style="color:{{ $wr >= 55 ? '#00D15B' : ($wr >= 45 ? '#FDB515' : '#ef4444') }};">{{ $wr }}%</div>
            </div>
            <div>
                <div class="sc-stat-label">Units</div>
                <div class="sc-stat-value" style="color:{{ $units >= 0 ? '#00D15B' : '#ef4444' }};">{{ $units >= 0 ? '+' : '' }}{{ number_format($units,1) }}</div>
            </div>
            <div>
                <div class="sc-stat-label">Record</div>
                <div class="sc-stat-value" style="color:#9a9a9a;font-size:.85rem;">{{ $wins }}-{{ $losses }}@if($pushes)-{{ $pushes }}@endif</div>
            </div>
        </div>

        {{-- Mini win rate bar --}}
        @if($total > 0)
        <div style="margin-top:12px;">
            <div style="height:4px;background:#1e1e1e;border-radius:3px;overflow:hidden;">
                <div style="width:{{ $wr }}%;height:100%;background:{{ $wr >= 55 ? '#00D15B' : ($wr >= 45 ? '#FDB515' : '#ef4444') }};border-radius:3px;transition:width .4s;"></div>
            </div>
        </div>
        @endif
    </div>
    @endforeach
</div>

{{-- Detailed Breakdown Table --}}
@if(!empty($streaks))
<div style="background:#141414;border:1px solid rgba(255,252,238,.07);border-radius:12px;overflow:hidden;">
    <div style="padding:14px 18px;border-bottom:1px solid rgba(255,252,238,.07);display:flex;align-items:center;justify-content:space-between;">
        <h2 style="font-family:'Clash Display',sans-serif;font-size:.95rem;font-weight:500;color:#FFFCEE;margin:0;">Full Breakdown</h2>
        <span style="font-size:11px;color:#6e6e6e;">All periods</span>
    </div>
    <div style="overflow-x:auto;">
        <table class="trends-table">
            <thead>
                <tr>
                    <th>Sport</th>
                    <th>Period</th>
                    <th>Streak</th>
                    <th>Best</th>
                    <th>Win %</th>
                    <th>Record</th>
                    <th>Units</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($streaks as $sport => $periods)
                    @php $colors = $sportColors[$sport] ?? ['#9a9a9a','rgba(255,255,255,.04)']; @endphp
                    @foreach($periods as $period => $data)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <div style="width:6px;height:6px;border-radius:50%;background:{{ $colors[0] }};flex-shrink:0;"></div>
                                <span style="font-weight:700;color:#FFFCEE;">{{ $sport }}</span>
                            </div>
                        </td>
                        <td style="color:#9a9a9a;">{{ str_replace('_',' ',ucfirst($period)) }}</td>
                        <td style="color:#9a9a9a;">{{ $data['current_streak'] }}W</td>
                        <td style="color:#9a9a9a;">{{ $data['best_streak'] }}W</td>
                        <td>
                            <span style="font-weight:700;color:{{ $data['win_rate']>=55?'#00D15B':($data['win_rate']>=45?'#FDB515':'#ef4444') }};">
                                {{ $data['win_rate'] }}%
                            </span>
                        </td>
                        <td style="color:#9a9a9a;font-size:12px;">{{ $data['total_wins'] }}-{{ $data['total_losses'] }}-{{ $data['total_pushes'] }}</td>
                        <td>
                            <span style="font-weight:700;color:{{ $data['total_units']>=0?'#00D15B':'#ef4444' }};">
                                {{ $data['total_units']>=0?'+':'' }}{{ number_format($data['total_units'],1) }}
                            </span>
                        </td>
                        <td>
                            @if($data['is_hot'])
                            <span style="background:rgba(0,209,91,.1);color:#00D15B;padding:2px 9px;border-radius:12px;font-size:10px;font-weight:700;border:1px solid #00D15B;">🔥 HOT</span>
                            @else
                            <span style="color:#3a3a3a;font-size:12px;">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
