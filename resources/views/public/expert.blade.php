@extends('layouts.public')
@section('title', $expert->name . ' — INSPIN Expert')

@section('content')
<div class="page" style="max-width:900px;">

    {{-- Back link --}}
    <a href="{{ route('about') }}" style="display:inline-flex;align-items:center;gap:6px;color:#6e6e6e;font-size:13px;text-decoration:none;margin-bottom:32px;" onmouseover="this.style.color='#FDB515'" onmouseout="this.style.color='#6e6e6e'">
        ← Back to About Us
    </a>

    {{-- Profile header --}}
    <div style="display:flex;gap:32px;align-items:flex-start;flex-wrap:wrap;margin-bottom:40px;padding:32px;background:#212121;border:1px solid rgba(255,252,238,.08);border-radius:16px;">

        {{-- Photo --}}
        <div style="flex-shrink:0;">
            @if($expert->avatar)
                <img src="{{ asset('storage/uploads/experts/'.$expert->avatar) }}"
                     alt="{{ $expert->name }}"
                     style="width:160px;height:160px;border-radius:12px;object-fit:cover;border:3px solid rgba(253,181,21,.3);"
                     onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                <div style="display:none;width:160px;height:160px;border-radius:12px;background:#FDB515;align-items:center;justify-content:center;color:#171818;font-weight:800;font-size:52px;">{{ strtoupper(substr($expert->name,0,1)) }}</div>
            @else
                <div style="width:160px;height:160px;border-radius:12px;background:#FDB515;display:flex;align-items:center;justify-content:center;color:#171818;font-weight:800;font-size:52px;">{{ strtoupper(substr($expert->name,0,1)) }}</div>
            @endif
        </div>

        {{-- Name, specialty, stats --}}
        <div style="flex:1;min-width:200px;">
            <h1 style="font-family:'Clash Display',sans-serif;font-size:2rem;font-weight:600;color:#FFFCEE;margin:0 0 6px;">{{ $expert->name }}</h1>

            @if($expert->specialty)
                <div style="font-size:12px;color:#FDB515;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:20px;">{{ $expert->specialty }}</div>
            @endif

            {{-- Stats row --}}
            <div style="display:flex;gap:24px;flex-wrap:wrap;">
                @if($winPct !== null)
                <div style="text-align:center;">
                    <div style="font-size:1.8rem;font-weight:800;color:#FDB515;">{{ $winPct }}%</div>
                    <div style="font-size:11px;color:#6e6e6e;text-transform:uppercase;letter-spacing:.5px;">Win Rate</div>
                </div>
                <div style="text-align:center;">
                    <div style="font-size:1.8rem;font-weight:800;color:#FFFCEE;">{{ $wins }}</div>
                    <div style="font-size:11px;color:#6e6e6e;text-transform:uppercase;letter-spacing:.5px;">Wins</div>
                </div>
                <div style="text-align:center;">
                    <div style="font-size:1.8rem;font-weight:800;color:#FFFCEE;">{{ $graded }}</div>
                    <div style="font-size:11px;color:#6e6e6e;text-transform:uppercase;letter-spacing:.5px;">Graded Picks</div>
                </div>
                @else
                <div style="color:#6e6e6e;font-size:13px;">No graded picks yet.</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Full bio --}}
    @if($expert->bio)
    <div style="margin-bottom:40px;">
        <h2 style="font-family:'Clash Display',sans-serif;font-size:1.1rem;font-weight:500;color:#FDB515;margin-bottom:14px;text-transform:uppercase;letter-spacing:.6px;">About</h2>
        <p style="color:#b0b0b0;font-size:15px;line-height:1.8;margin:0;">{{ $expert->bio }}</p>
    </div>
    @endif

    {{-- Last 10 picks --}}
    <div>
        <h2 style="font-family:'Clash Display',sans-serif;font-size:1.1rem;font-weight:500;color:#FDB515;margin-bottom:20px;text-transform:uppercase;letter-spacing:.6px;">Last 10 Picks</h2>

        @if($picks->count() > 0)
        <div style="display:flex;flex-direction:column;gap:12px;">
            @foreach($picks as $pick)
            @php
                $rawTime = $pick->game_time ? (string)$pick->game_time : '00:00:00';
                $timeStr = strlen($rawTime) === 5 ? $rawTime.':00' : substr($rawTime, 0, 8);
                $gameStart = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pick->game_date->format('Y-m-d').' '.$timeStr, 'America/New_York');
                $now = \Carbon\Carbon::now('America/New_York');
                $status = $pick->result !== 'pending' ? 'Graded' : ($now->gte($gameStart) ? 'Started' : 'Active');

                $statusColor = match($status) {
                    'Active'  => ['bg'=>'rgba(0,209,91,.12)','border'=>'#00D15B','text'=>'#00D15B'],
                    'Started' => ['bg'=>'rgba(239,68,68,.12)','border'=>'#ef4444','text'=>'#ef4444'],
                    'Graded'  => ['bg'=>'rgba(100,100,100,.12)','border'=>'#555','text'=>'#888'],
                };

                $resultColor = match($pick->result) {
                    'win'  => '#00D15B',
                    'loss' => '#ef4444',
                    'push' => '#FDB515',
                    default => '#6e6e6e',
                };
            @endphp
            <div style="background:#1a1a1a;border:1px solid rgba(255,252,238,.07);border-radius:10px;padding:16px 20px;display:flex;align-items:center;gap:16px;flex-wrap:wrap;">

                {{-- Date + sport --}}
                <div style="min-width:80px;">
                    <div style="font-size:12px;color:#6e6e6e;">{{ $pick->game_date->format('M j, Y') }}</div>
                    @if($pick->sport)
                        <div style="font-size:11px;color:#FDB515;font-weight:700;text-transform:uppercase;letter-spacing:.5px;margin-top:2px;">{{ $pick->sport }}</div>
                    @endif
                </div>

                {{-- Teams + pick --}}
                <div style="flex:1;min-width:180px;">
                    <div style="font-size:14px;font-weight:600;color:#FFFCEE;margin-bottom:4px;">
                        {{ $pick->team1_name }} <span style="color:#4a4a4a;margin:0 4px;">vs</span> {{ $pick->team2_name }}
                    </div>
                    @auth
                        @if(auth()->user()->canViewPick($pick))
                            <div style="font-size:12px;color:#9a9a9a;">{{ $pick->pick }}</div>
                        @else
                            <div style="font-size:12px;color:#6e6e6e;">🔒 {{ $pick->stars }}★ Pick — Upgrade to view</div>
                        @endif
                    @else
                        <div style="font-size:12px;color:#6e6e6e;">🔒 Members only</div>
                    @endauth
                </div>

                {{-- Stars --}}
                <div style="font-size:13px;color:#FDB515;font-weight:700;">
                    {{ str_repeat('★', min($pick->stars, 5)) }}{{ $pick->stars > 5 ? '+'.$pick->stars : '' }}
                </div>

                {{-- Status --}}
                <div style="background:{{ $statusColor['bg'] }};border:1px solid {{ $statusColor['border'] }};color:{{ $statusColor['text'] }};font-size:11px;font-weight:800;padding:3px 10px;border-radius:20px;white-space:nowrap;">{{ $status }}</div>

                {{-- Result --}}
                @if($pick->result !== 'pending')
                <div style="font-size:13px;font-weight:800;color:{{ $resultColor }};text-transform:uppercase;">
                    {{ $pick->result }}
                    @if($pick->units_result)
                        <span style="font-size:11px;font-weight:600;">({{ $pick->units_result > 0 ? '+' : '' }}{{ $pick->units_result }}u)</span>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
            <div style="color:#6e6e6e;font-size:14px;padding:20px 0;">No picks posted yet for this expert.</div>
        @endif
    </div>

    {{-- CTA --}}
    <div style="text-align:center;margin-top:48px;padding:32px;background:rgba(253,181,21,.04);border:1px solid rgba(253,181,21,.12);border-radius:12px;">
        <div style="color:#FFFCEE;font-size:1.1rem;font-weight:600;margin-bottom:8px;">Follow {{ $expert->name }}'s picks</div>
        <div style="color:#6e6e6e;font-size:13px;margin-bottom:20px;">Join INSPIN and get access to all expert picks, analysis, and simulation model results.</div>
        <a href="{{ route('join') }}" style="display:inline-block;padding:12px 36px;background:#FDB515;color:#171818;border-radius:50px;font-weight:700;text-decoration:none;font-size:14px;box-shadow:0 0 16px rgba(253,181,21,.3);">Get Started Free</a>
    </div>

</div>
@endsection
