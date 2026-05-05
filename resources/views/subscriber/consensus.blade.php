@extends('layouts.subscriber')
@section('title', 'Consensus - INSPIN')
@section('page-title', 'Top Consensus')

@section('content')
{{-- Sport filter --}}
<div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:20px;">
    @foreach([''=>'All','NFL'=>'NFL','NCAAF'=>'NCAAF','NBA'=>'NBA','NCAAB'=>'NCAAB','MLB'=>'MLB','NHL'=>'NHL'] as $val=>$label)
    <a href="{{ route('subscriber.consensus', $val ? ['sport'=>$val] : []) }}"
       style="padding:7px 14px;border-radius:50px;font-size:12px;font-weight:600;text-decoration:none;
              border:1px solid {{ $sport===$val?'#FDB515':'#2d2d2d' }};
              color:{{ $sport===$val?'#FDB515':'#9a9a9a' }};background:transparent;">
        {{ $label }}
    </a>
    @endforeach
</div>

<div style="display:flex;flex-direction:column;gap:10px;">
    @forelse($consensus as $game)
    @php
        $sportColors = ['NFL'=>['#3b82f6','rgba(59,130,246,.08)'],'NBA'=>['#ef4444','rgba(220,38,38,.08)'],'MLB'=>['#22c55e','rgba(34,197,94,.08)'],'NHL'=>['#a855f7','rgba(168,85,247,.08)'],'NCAAF'=>['#f97316','rgba(249,115,22,.08)'],'NCAAB'=>['#f97316','rgba(249,115,22,.08)']];
        $sc = $sportColors[$game->league] ?? ['#FDB515','rgba(253,181,21,.08)'];
        $pub = $game->public_pct_home ?? 0;
        $mon = $game->money_pct_home ?? 0;
        $mlA = $game->moneyline_away ?? '—'; $mlH = $game->moneyline_home ?? '—';
        $mlAColor = (is_numeric(str_replace(['+'],'',$mlA)) && (int)str_replace('+','',$mlA) > 0) ? '#FDB515' : '#FFFCEE';
        $mlHColor = (is_numeric(str_replace(['+'],'',$mlH)) && (int)str_replace('+','',$mlH) > 0) ? '#FDB515' : '#FFFCEE';
    @endphp
    <div style="background:#1a1a1a;border:1px solid rgba(255,252,238,.07);border-radius:10px;overflow:hidden;transition:border-color .2s;" onmouseover="this.style.borderColor='rgba(253,181,21,.2)'" onmouseout="this.style.borderColor='rgba(255,252,238,.07)'">
        {{-- Header --}}
        <div style="padding:10px 16px;border-bottom:1px solid rgba(255,252,238,.05);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:{{ $sc[1] }};color:{{ $sc[0] }};border:1px solid {{ $sc[0] }}44;padding:2px 8px;border-radius:6px;font-size:10px;font-weight:700;">{{ $game->league }}</span>
                <span style="font-size:13px;font-weight:600;color:#FFFCEE;">{{ $game->away_team }} @ {{ $game->home_team }}</span>
            </div>
            <span style="font-size:11px;color:#6e6e6e;">{{ $game->game_date?->format('M d, g:i A') ?? 'TBD' }} ET</span>
        </div>
        {{-- Body --}}
        <div style="padding:12px 16px;display:grid;grid-template-columns:1fr 1fr 1fr 180px 180px;gap:12px;align-items:center;">
            <div>
                <div style="font-size:11px;color:#6e6e6e;margin-bottom:4px;">Away / Home</div>
                <div style="font-size:12px;font-weight:600;color:#FFFCEE;">{{ $game->away_team }}</div>
                <div style="font-size:12px;font-weight:600;color:#FFFCEE;">{{ $game->home_team }}</div>
            </div>
            <div>
                <div style="font-size:11px;color:#6e6e6e;margin-bottom:4px;">Moneyline</div>
                <div style="font-size:13px;font-weight:600;color:{{ $mlAColor }}">{{ $mlA }}</div>
                <div style="font-size:13px;font-weight:600;color:{{ $mlHColor }}">{{ $mlH }}</div>
            </div>
            <div>
                <div style="font-size:11px;color:#6e6e6e;margin-bottom:4px;">Spread / Total</div>
                <div style="font-size:12px;color:#9a9a9a;">{{ $game->spread_away ?? '—' }} / <span style="color:#00D15B;">{{ $game->total_over ?? '—' }}</span></div>
                <div style="font-size:12px;color:#9a9a9a;">{{ $game->spread_home ?? '—' }} / <span style="color:#ef4444;">{{ $game->total_under ?? '—' }}</span></div>
            </div>
            <div>
                <div style="font-size:10px;color:#6e6e6e;margin-bottom:5px;font-weight:600;">Public {{ $pub }}%</div>
                <div style="height:5px;background:#2a2a2a;border-radius:3px;overflow:hidden;"><div style="width:{{ $pub }}%;height:100%;background:#00D15B;border-radius:3px;"></div></div>
            </div>
            <div>
                @if($mon)
                <div style="font-size:10px;color:#6e6e6e;margin-bottom:5px;font-weight:600;">Sharp {{ $mon }}%</div>
                <div style="height:5px;background:#2a2a2a;border-radius:3px;overflow:hidden;"><div style="width:{{ $mon }}%;height:100%;background:#ef4444;border-radius:3px;"></div></div>
                @else
                <div style="font-size:11px;color:#4a4a4a;">No sharp data</div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:48px 0;color:#4a4a4a;">
        <div style="font-size:2.5rem;margin-bottom:12px;">📊</div>
        <p style="color:#6e6e6e;">No consensus data available.</p>
    </div>
    @endforelse
</div>
<div style="margin-top:24px;">{{ $consensus->links() }}</div>
@endsection
