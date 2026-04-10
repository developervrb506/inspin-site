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

        @if($picks->count() > 0)
        <div class="grid grid-2">
            @foreach($picks as $pick)
            <div class="card">
                <div class="card-body">
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
                        <div>
                            <div style="display:flex;gap:6px;align-items:center;margin-bottom:4px;">
                                <span class="badge badge-{{ strtolower($pick->sport) }}">{{ $pick->sport }}</span>
                                @if($pick->result && $pick->result !== 'pending')
                                    <span class="badge badge-{{ $pick->result === 'win' ? 'success' : ($pick->result === 'loss' ? 'danger' : 'neutral') }}">{{ ucfirst($pick->result) }}</span>
                                @endif
                                @if($pick->is_whale_exclusive)
                                    <span class="badge" style="background:#f59e0b;color:#fff;">WHALE</span>
                                @endif
                            </div>
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:4px;">
                                @if($pick->team1_logo)
                                <img src="{{ asset('storage/' . $pick->team1_logo) }}" alt="{{ $pick->team1_name }}" style="width:32px;height:32px;object-fit:contain;">
                                @else
                                <div style="width:32px;height:32px;border-radius:50%;background:#e2e8f0;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#64748b;">{{ strtoupper(substr($pick->team1_name, 0, 2)) }}</div>
                                @endif
                                <span style="font-size:15px;font-weight:700;color:#0f172a;">{{ $pick->team1_name }}</span>
                                <span style="font-size:12px;color:#94a3b8;">vs</span>
                                @if($pick->team2_logo)
                                <img src="{{ asset('storage/' . $pick->team2_logo) }}" alt="{{ $pick->team2_name }}" style="width:32px;height:32px;object-fit:contain;">
                                @else
                                <div style="width:32px;height:32px;border-radius:50%;background:#e2e8f0;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:#64748b;">{{ strtoupper(substr($pick->team2_name, 0, 2)) }}</div>
                                @endif
                                <span style="font-size:15px;font-weight:700;color:#0f172a;">{{ $pick->team2_name }}</span>
                            </div>
                            @if($pick->venue)
                                <div style="font-size:12px;color:#94a3b8;">{{ $pick->venue }}</div>
                            @endif
                            <div style="font-size:12px;color:#94a3b8;">{{ $pick->game_date?->format('M d, Y') }}{{ $pick->game_time ? ' @ ' . $pick->game_time : '' }}</div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-size:11px;color:#94a3b8;text-transform:uppercase;font-weight:600;">Stars</div>
                            <div style="color:#d97706;font-size:18px;">{{ $pick->stars_display }}</div>
                        </div>
                    </div>
                    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:10px 14px;margin-bottom:8px;">
                        <div style="font-size:11px;color:#16a34a;text-transform:uppercase;font-weight:600;margin-bottom:2px;">Pick</div>
                        <div style="font-size:15px;font-weight:700;color:#0f172a;">{{ $pick->pick }}</div>
                    </div>
                    @if($pick->units)
                        <div style="font-size:13px;color:#64748b;">Units: {{ $pick->units }}</div>
                    @endif
                    @if($pick->expert_name)
                        <div style="margin-top:12px;padding-top:12px;border-top:1px solid #f1f5f9;display:flex;align-items:center;gap:8px;">
                            <div style="width:28px;height:28px;border-radius:50%;background:#4f46e5;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:11px;">{{ substr($pick->expert_name, 0, 1) }}</div>
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
            <h3>No active picks at this time</h3>
            <p>Check back soon for our latest picks.</p>
        </div>
        @endif
    </div>
</div>
@endsection