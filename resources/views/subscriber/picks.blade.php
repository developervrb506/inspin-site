@extends('layouts.subscriber')
@section('title', 'My Picks - INSPIN')
@section('page-title', 'My Picks')

@push('styles')
<style>
.picks-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:14px; }
@media(max-width:860px){ .picks-grid { grid-template-columns:1fr; } }

.tab-bar { display:flex; gap:4px; background:#0d0d0d; border:1px solid rgba(255,252,238,.07); border-radius:10px; padding:4px; margin-bottom:18px; }
.tab-btn {
    flex:1; padding:9px 12px; border-radius:7px; border:none; cursor:pointer;
    font-size:12.5px; font-weight:600; font-family:'DM Sans',sans-serif;
    background:transparent; color:#6e6e6e; transition:all .18s; display:flex; align-items:center; justify-content:center; gap:6px;
}
.tab-btn.active { background:#212121; color:#FFFCEE; box-shadow:0 1px 4px rgba(0,0,0,.4); }
.tab-btn:hover:not(.active) { color:#9a9a9a; }
.tab-count { font-size:10px; padding:1px 6px; border-radius:10px; background:rgba(255,252,238,.08); color:#6e6e6e; }
.tab-btn.active .tab-count { background:rgba(253,181,21,.15); color:#FDB515; }

.pick-card {
    background:#141414; border:1px solid rgba(255,252,238,.07);
    border-radius:12px; overflow:hidden; transition:border-color .2s;
}
.pick-card:hover { border-color:rgba(253,181,21,.2); }
.pick-card.graded-win  { border-color:rgba(0,209,91,.2); }
.pick-card.graded-loss { border-color:rgba(239,68,68,.15); }
</style>
@endpush

@section('content')
@php
    $sportEmojis = ['MLB'=>'⚾','NFL'=>'🏈','NBA'=>'🏀','NHL'=>'🏒','NCAAF'=>'🏈','NCAAB'=>'🏀','MMA'=>'🥊','GOLF'=>'⛳'];
    $spColors    = ['MLB'=>['#22c55e','rgba(34,197,94,.1)'],'NFL'=>['#3b82f6','rgba(59,130,246,.1)'],'NBA'=>['#ef4444','rgba(220,38,38,.1)'],'NHL'=>['#a855f7','rgba(168,85,247,.1)'],'NCAAF'=>['#f97316','rgba(249,115,22,.1)'],'NCAAB'=>['#f59e0b','rgba(245,158,11,.1)']];
    $baseParams  = array_filter(['sport'=>$sport,'period'=>$period,'tab'=>$tab]);
@endphp

{{-- Stats bar --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;">
    @foreach([
        ['label'=>'Record', 'value'=>$wins.'-'.$losses.($pushes>0?'-'.$pushes:''), 'color'=>'#9a9a9a'],
        ['label'=>'Win Rate', 'value'=>$wr.'%', 'color'=>$wr>=55?'#00D15B':($wr>=45?'#FDB515':($total>0?'#ef4444':'#6e6e6e'))],
        ['label'=>'Total Units', 'value'=>($units>=0?'+':'').number_format($units,2), 'color'=>$units>=0?'#00D15B':'#ef4444'],
        ['label'=>'Since', 'value'=>$sub->starts_at->format('M d'), 'color'=>'#9a9a9a', 'sub'=>$sub->max_stars.'★ access'],
    ] as $s)
    <div style="background:#141414;border:1px solid rgba(255,252,238,.07);border-radius:10px;padding:12px 14px;">
        <div style="font-size:9px;text-transform:uppercase;letter-spacing:.5px;color:#6e6e6e;font-weight:700;margin-bottom:5px;">{{ $s['label'] }}</div>
        <div style="font-family:'Clash Display',sans-serif;font-size:1.25rem;font-weight:600;color:{{ $s['color'] }};line-height:1;">{{ $s['value'] }}</div>
        @isset($s['sub'])<div style="font-size:10px;color:#4a4a4a;margin-top:3px;">{{ $s['sub'] }}</div>@endisset
    </div>
    @endforeach
</div>

{{-- Tabs --}}
<div class="tab-bar">
    <a href="?{{ http_build_query(array_merge($baseParams,['tab'=>'all'])) }}" class="tab-btn {{ $tab==='all'?'active':'' }}" style="text-decoration:none;">
        All Picks <span class="tab-count">{{ $countAll }}</span>
    </a>
    <a href="?{{ http_build_query(array_merge($baseParams,['tab'=>'pending'])) }}" class="tab-btn {{ $tab==='pending'?'active':'' }}" style="text-decoration:none;">
        🟢 Pending <span class="tab-count">{{ $countPending }}</span>
    </a>
    <a href="?{{ http_build_query(array_merge($baseParams,['tab'=>'results'])) }}" class="tab-btn {{ $tab==='results'?'active':'' }}" style="text-decoration:none;">
        🏁 Results <span class="tab-count">{{ $countResults }}</span>
    </a>
</div>

{{-- Filters row --}}
<div style="display:flex;gap:10px;margin-bottom:20px;flex-wrap:wrap;align-items:center;">
    {{-- Sport --}}
    <div style="display:flex;gap:5px;flex-wrap:wrap;">
        @foreach([''=>'All','NFL'=>'NFL','NCAAF'=>'NCAAF','NBA'=>'NBA','NCAAB'=>'NCAAB','MLB'=>'MLB','NHL'=>'NHL'] as $val=>$label)
        <a href="?{{ http_build_query(array_merge($baseParams,['sport'=>$val,'tab'=>$tab])) }}"
           style="padding:6px 13px;border-radius:50px;font-size:11.5px;font-weight:600;text-decoration:none;
                  border:1px solid {{ ($sport??'')===$val?'#FDB515':'#2d2d2d' }};
                  color:{{ ($sport??'')===$val?'#FDB515':'#9a9a9a' }};
                  background:{{ ($sport??'')===$val?'rgba(253,181,21,.05)':'transparent' }};">{{ $label }}</a>
        @endforeach
    </div>

    <div style="width:1px;height:20px;background:rgba(255,252,238,.07);"></div>

    {{-- Period --}}
    <div style="display:flex;gap:5px;">
        @foreach(['all'=>'All Time','month'=>'30 Days','week'=>'7 Days'] as $key=>$label)
        <a href="?{{ http_build_query(array_merge($baseParams,['period'=>$key,'tab'=>$tab])) }}"
           style="padding:6px 13px;border-radius:50px;font-size:11.5px;font-weight:600;text-decoration:none;
                  border:1px solid {{ $period===$key?'rgba(255,252,238,.25)':'#2d2d2d' }};
                  color:{{ $period===$key?'#FFFCEE':'#9a9a9a' }};
                  background:{{ $period===$key?'rgba(255,252,238,.05)':'transparent' }};">{{ $label }}</a>
        @endforeach
    </div>
</div>

{{-- Pick cards --}}
@if($picks->count() > 0)
<div class="picks-grid">
    @foreach($picks as $pick)
    @php
        $timeStr   = $pick->game_time ? \Carbon\Carbon::parse($pick->game_time)->format('H:i:s') : '00:00:00';
        $gameStart = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pick->game_date->format('Y-m-d').' '.$timeStr, 'America/New_York');
        $now       = \Carbon\Carbon::now('America/New_York');
        $isGraded  = in_array($pick->result, ['win','loss','push']);
        $status    = $isGraded ? ucfirst($pick->result) : ($gameStart->lte($now) ? 'Started' : 'Active');
        $statusColors = ['win'=>'#00D15B','loss'=>'#ef4444','push'=>'#FDB515','Win'=>'#00D15B','Loss'=>'#ef4444','Push'=>'#FDB515','Started'=>'#ef4444','Active'=>'#00D15B'];
        $sc  = $statusColors[$status] ?? '#6e6e6e';
        $spc = $spColors[$pick->sport] ?? ['#FDB515','rgba(253,181,21,.1)'];
        $cardClass = $isGraded ? ($pick->result==='win'?'graded-win':($pick->result==='loss'?'graded-loss':'')) : '';
        $t1init = strtoupper(substr($pick->team1_name ?? 'T1', 0, 2));
        $t2init = strtoupper(substr($pick->team2_name ?? 'T2', 0, 2));
        $p1 = $pick->team1_percent ?? 50;
        $p2 = $pick->team2_percent ?? (100 - $p1);
    @endphp
    <div class="pick-card {{ $cardClass }}">
        {{-- Card header --}}
        <div style="padding:12px 14px;border-bottom:1px solid rgba(255,252,238,.05);display:flex;align-items:center;justify-content:space-between;">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="background:{{ $spc[1] }};color:{{ $spc[0] }};padding:2px 8px;border-radius:5px;font-size:10px;font-weight:700;text-transform:uppercase;">{{ $pick->sport }}</span>
                <span style="font-size:11px;color:#6e6e6e;">{{ $pick->game_date->format('M d') }}{{ $pick->game_time ? ' · '.\Carbon\Carbon::parse($pick->game_time)->format('g:i A').' ET' : '' }}</span>
            </div>
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="font-size:11px;font-weight:700;color:{{ $sc }};">{{ $status }}</span>
                @if($pick->stars === 10)
                <span style="font-size:10px;font-weight:800;color:#FDB515;">★10 WHALE</span>
                @else
                <span style="font-size:13px;color:#FDB515;letter-spacing:1px;">{{ str_repeat('★',(int)$pick->stars) }}<span style="color:#3a3a3a;">{{ str_repeat('★',max(0,5-(int)$pick->stars)) }}</span></span>
                @endif
            </div>
        </div>

        {{-- Teams + progress bars --}}
        <div style="padding:12px 14px;">
            @foreach([
                ['init'=>$t1init,'name'=>$pick->team1_name,'logo'=>$pick->team1_logo,'pct'=>$p1],
                ['init'=>$t2init,'name'=>$pick->team2_name,'logo'=>$pick->team2_logo,'pct'=>$p2],
            ] as $team)
            <div style="margin-bottom:8px;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                    <div style="width:28px;height:28px;border-radius:50%;background:#212121;flex-shrink:0;display:flex;align-items:center;justify-content:center;overflow:hidden;border:1px solid rgba(255,252,238,.07);">
                        @if($team['logo'])
                            <img src="{{ asset('storage/'.$team['logo']) }}" style="width:22px;height:22px;object-fit:contain;" onerror="this.style.display='none';this.nextElementSibling.style.display='block'">
                            <span style="display:none;font-size:8px;font-weight:800;color:#9a9a9a;">{{ $team['init'] }}</span>
                        @else
                            <span style="font-size:8px;font-weight:800;color:#9a9a9a;">{{ $team['init'] }}</span>
                        @endif
                    </div>
                    <span style="font-size:13px;font-weight:600;color:#FFFCEE;flex:1;">{{ $team['name'] }}</span>
                    <span style="font-size:10px;font-weight:700;color:#00D15B;background:rgba(0,209,91,.1);border:1px solid rgba(0,209,91,.2);padding:1px 7px;border-radius:10px;">{{ $team['pct'] }}%</span>
                </div>
                <div style="height:3px;background:#1e1e1e;border-radius:2px;overflow:hidden;">
                    <div style="width:{{ $team['pct'] }}%;height:100%;background:#00D15B;border-radius:2px;"></div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- The Pick --}}
        <div style="margin:0 14px 12px;background:rgba(253,181,21,.05);border:1px solid rgba(253,181,21,.12);border-radius:8px;padding:10px 12px;">
            <div style="font-size:9px;color:#FDB515;text-transform:uppercase;letter-spacing:.5px;font-weight:700;margin-bottom:4px;">The Pick</div>
            <div style="font-size:14px;font-weight:600;color:#FFFCEE;">{{ $pick->pick }}</div>
            @if($pick->pick_type)
            <div style="font-size:10px;color:#6e6e6e;margin-top:3px;">{{ $pick->pick_type }}</div>
            @endif
        </div>

        {{-- Result footer (only if graded) --}}
        @if($isGraded)
        <div style="padding:10px 14px;border-top:1px solid rgba(255,252,238,.05);display:flex;align-items:center;justify-content:space-between;background:rgba({{ $pick->result==='win'?'0,209,91':($pick->result==='loss'?'239,68,68':'253,181,21') }},.04);">
            <div style="display:flex;align-items:center;gap:8px;">
                <span style="width:8px;height:8px;border-radius:50%;background:{{ $sc }};display:inline-block;"></span>
                <span style="font-size:12px;font-weight:700;color:{{ $sc }};">{{ strtoupper($pick->result) }}</span>
            </div>
            @if($pick->units_result !== null)
            <span style="font-family:'Clash Display',sans-serif;font-size:1rem;font-weight:700;color:{{ $sc }};">
                {{ $pick->units_result >= 0 ? '+' : '' }}{{ $pick->units_result }} units
            </span>
            @endif
        </div>
        @endif

        {{-- Expert --}}
        @if($pick->expert_name)
        <div style="padding:8px 14px;border-top:1px solid rgba(255,252,238,.04);display:flex;align-items:center;gap:7px;">
            <div style="width:20px;height:20px;border-radius:50%;background:#FDB515;color:#171818;display:flex;align-items:center;justify-content:center;font-size:8px;font-weight:800;">{{ substr($pick->expert_name,0,1) }}</div>
            <span style="font-size:11px;color:#6e6e6e;">{{ $pick->expert_name }}</span>
        </div>
        @endif
    </div>
    @endforeach
</div>

<div style="margin-top:24px;">{{ $picks->links() }}</div>

@else
<div style="text-align:center;padding:64px 0;background:#141414;border:1px solid rgba(255,252,238,.07);border-radius:12px;">
    <div style="font-size:3rem;margin-bottom:14px;">
        {{ $tab==='results' ? '🏁' : ($tab==='pending' ? '⏳' : '🏅') }}
    </div>
    <h3 style="font-family:'Clash Display',sans-serif;font-weight:500;color:#FFFCEE;margin-bottom:6px;">
        {{ $tab==='results' ? 'No graded picks yet' : ($tab==='pending' ? 'No pending picks' : 'No picks found') }}
    </h3>
    <p style="font-size:13px;color:#6e6e6e;">
        {{ $tab==='results' ? 'Results will appear here once picks are graded.' : 'Try adjusting the sport or time period filter.' }}
    </p>
</div>
@endif
@endsection
