@extends('layouts.public')
@section('title', 'Picks - INSPIN')

@section('content')
<div class="section">
    <div class="container">
        <h1 class="section-title">Expert Picks</h1>
        <p class="section-sub">Our latest betting picks across all sports</p>

        <div class="sport-filter">
            <a href="{{ route('picks') }}" class="{{ !$sport ? 'active' : '' }}">All</a>
            <a href="{{ route('picks', ['sport' => 'NFL']) }}" class="{{ $sport === 'NFL' ? 'active' : '' }}">NFL</a>
            <a href="{{ route('picks', ['sport' => 'NCAAF']) }}" class="{{ $sport === 'NCAAF' ? 'active' : '' }}">NCAAF</a>
            <a href="{{ route('picks', ['sport' => 'NBA']) }}" class="{{ $sport === 'NBA' ? 'active' : '' }}">NBA</a>
            <a href="{{ route('picks', ['sport' => 'NCAAB']) }}" class="{{ $sport === 'NCAAB' ? 'active' : '' }}">NCAAB</a>
            <a href="{{ route('picks', ['sport' => 'MLB']) }}" class="{{ $sport === 'MLB' ? 'active' : '' }}">MLB</a>
            <a href="{{ route('picks', ['sport' => 'NHL']) }}" class="{{ $sport === 'NHL' ? 'active' : '' }}">NHL</a>
        </div>

        @guest
        <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:10px;padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
            <div>
                <strong style="color:#1e40af;">Login or join to see full pick details.</strong>
                <span style="color:#3b82f6;font-size:14px;"> Game info and status are visible to all.</span>
            </div>
            <div style="display:flex;gap:8px;">
                <button onclick="openModal()" style="padding:8px 18px;background:#dc2626;color:white;border:none;border-radius:7px;font-weight:700;cursor:pointer;font-size:13px;">Login</button>
                <a href="{{ route('join') }}" style="padding:8px 18px;background:#2563eb;color:white;border-radius:7px;font-weight:700;text-decoration:none;font-size:13px;">Join Now</a>
            </div>
        </div>
        @endguest

        @if($picks->count() > 0)
        <div class="grid grid-2">
            @foreach($picks as $pick)
            @php
                $timeStr = $pick->game_time ? \Carbon\Carbon::parse($pick->game_time)->format('H:i:s') : '00:00:00';
                $gameStart = \Carbon\Carbon::parse($pick->game_date->format('Y-m-d') . ' ' . $timeStr);
                $status = $pick->result !== 'pending' ? 'GRADED' : ($gameStart->isPast() ? 'STARTED' : 'ACTIVE');
                $statusColor = $status === 'ACTIVE' ? '#16a34a' : ($status === 'STARTED' ? '#d97706' : '#64748b');
                $statusBg = $status === 'ACTIVE' ? '#f0fdf4' : ($status === 'STARTED' ? '#fffbeb' : '#f1f5f9');
            @endphp
            <div class="card">
                <div class="card-body">
                    {{-- Header: Badges + Stars --}}
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
                        <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
                            <span class="badge badge-{{ strtolower($pick->sport) }}">{{ $pick->sport }}</span>
                            <span style="background:{{ $statusBg }};color:{{ $statusColor }};border:1px solid {{ $statusColor }}44;padding:2px 9px;border-radius:4px;font-size:11px;font-weight:700;">{{ $status }}</span>
                            @if($pick->result !== 'pending')
                                <span class="badge badge-{{ $pick->result === 'win' ? 'success' : ($pick->result === 'loss' ? 'danger' : 'neutral') }}">{{ strtoupper($pick->result) }}</span>
                            @endif
                            @if($pick->is_whale_exclusive)
                                <span class="badge" style="background:#f59e0b;color:#fff;">WHALE</span>
                            @endif
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <div style="font-size:10px;color:#94a3b8;text-transform:uppercase;font-weight:600;">Stars</div>
                            <div style="color:#d97706;font-size:16px;">{{ $pick->stars_display }}</div>
                        </div>
                    </div>

                    {{-- Teams --}}
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                        @if($pick->team1_logo)
                        <img src="{{ asset('storage/' . $pick->team1_logo) }}" alt="{{ $pick->team1_name }}" style="width:32px;height:32px;object-fit:contain;">
                        @else
                        <div style="width:32px;height:32px;border-radius:50%;background:#e2e8f0;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#64748b;">{{ strtoupper(substr($pick->team1_name,0,2)) }}</div>
                        @endif
                        <span style="font-size:15px;font-weight:700;color:#0f172a;">{{ $pick->team1_name }}</span>
                        <span style="font-size:12px;color:#94a3b8;">vs</span>
                        @if($pick->team2_logo)
                        <img src="{{ asset('storage/' . $pick->team2_logo) }}" alt="{{ $pick->team2_name }}" style="width:32px;height:32px;object-fit:contain;">
                        @else
                        <div style="width:32px;height:32px;border-radius:50%;background:#e2e8f0;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#64748b;">{{ strtoupper(substr($pick->team2_name,0,2)) }}</div>
                        @endif
                        <span style="font-size:15px;font-weight:700;color:#0f172a;">{{ $pick->team2_name }}</span>
                    </div>

                    {{-- Game info --}}
                    @if($pick->venue)
                        <div style="font-size:12px;color:#94a3b8;margin-bottom:2px;">{{ $pick->venue }}</div>
                    @endif
                    <div style="font-size:12px;color:#94a3b8;margin-bottom:12px;">
                        {{ $pick->game_date?->format('M d, Y') }}
                        {{ $pick->game_time ? ' @ ' . \Carbon\Carbon::parse($pick->game_time)->format('g:i A') . ' ET' : '' }}
                    </div>

                    {{-- Pick — gated --}}
                    @auth
                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:10px 14px;margin-bottom:8px;">
                        <div style="font-size:10px;color:#16a34a;text-transform:uppercase;font-weight:600;margin-bottom:2px;">Pick</div>
                        <div style="font-size:15px;font-weight:700;color:#0f172a;">{{ $pick->pick }}</div>
                        @if($pick->units_result !== null)
                            <div style="margin-top:4px;font-size:12px;color:{{ $pick->result === 'win' ? '#16a34a' : ($pick->result === 'loss' ? '#dc2626' : '#d97706') }};font-weight:600;">
                                {{ $pick->result === 'win' ? '+' : '' }}{{ $pick->units_result }} units
                            </div>
                        @endif
                    </div>
                    @else
                    <div style="display:flex;gap:8px;margin-bottom:8px;">
                        <button onclick="openModal()" style="flex:1;padding:9px;background:#dc2626;color:white;border:none;border-radius:8px;font-weight:700;cursor:pointer;font-size:13px;">Login</button>
                        <a href="{{ route('join') }}" style="flex:1;padding:9px;background:#2563eb;color:white;border-radius:8px;font-weight:700;text-align:center;text-decoration:none;font-size:13px;display:flex;align-items:center;justify-content:center;">Join Now</a>
                    </div>
                    @endauth

                    @if($pick->expert_name)
                        <div style="margin-top:10px;padding-top:10px;border-top:1px solid #f1f5f9;display:flex;align-items:center;gap:8px;">
                            <div style="width:26px;height:26px;border-radius:50%;background:#4f46e5;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;">{{ substr($pick->expert_name,0,1) }}</div>
                            <div style="font-size:13px;font-weight:600;color:#0f172a;">{{ $pick->expert_name }}</div>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        {{ $picks->links() }}
        @else
        <div class="empty-state" style="padding:48px 0;">
            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="width:48px;height:48px;margin-bottom:16px;color:#cbd5e1;"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
            <h3>No picks at this time</h3>
            <p>Check back soon for our latest picks.</p>
        </div>
        @endif
    </div>
</div>
@endsection
