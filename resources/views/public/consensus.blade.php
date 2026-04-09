@extends('layouts.public')
@section('title', 'Top Consensus - INSPIN')

@section('content')
<div class="section">
    <div class="container">
        <h1 class="section-title">Top Consensus</h1>
        <p class="section-sub">See where the betting public is placing their money across all major sports</p>

        <div class="sport-filter">
            <a href="{{ route('consensus') }}" class="{{ !$sport ? 'active' : '' }}">All</a>
            <a href="{{ route('consensus', ['sport' => 'NFL']) }}" class="{{ $sport === 'NFL' ? 'active' : '' }}">NFL</a>
            <a href="{{ route('consensus', ['sport' => 'NCAAF']) }}" class="{{ $sport === 'NCAAF' ? 'active' : '' }}">NCAAF</a>
            <a href="{{ route('consensus', ['sport' => 'NBA']) }}" class="{{ $sport === 'NBA' ? 'active' : '' }}">NBA</a>
            <a href="{{ route('consensus', ['sport' => 'NCAAB']) }}" class="{{ $sport === 'NCAAB' ? 'active' : '' }}">NCAAB</a>
            <a href="{{ route('consensus', ['sport' => 'MLB']) }}" class="{{ $sport === 'MLB' ? 'active' : '' }}">MLB</a>
            <a href="{{ route('consensus', ['sport' => 'NHL']) }}" class="{{ $sport === 'NHL' ? 'active' : '' }}">NHL</a>
        </div>

        <table class="c-table">
            <thead>
                <tr>
                    <th>Matchup</th>
                    <th>Moneyline</th>
                    <th>Spread</th>
                    <th>Total</th>
                    <th>Public %</th>
                    <th>Money %</th>
                </tr>
            </thead>
            <tbody>
                @forelse($consensus as $game)
                <tr>
                    <td>
                        <div style="font-weight:600;color:#0f172a;">{{ $game->away_team }}</div>
                        <div style="font-weight:600;color:#0f172a;">{{ $game->home_team }}</div>
                        <div style="font-size:11px;color:#64748b;">{{ $game->league }} - {{ $game->game_date?->format('M d, g:i A') ?? 'TBD' }}</div>
                    </td>
                    <td>
                        <div style="font-size:12px;">{{ $game->moneyline_away }}</div>
                        <div style="font-size:12px;">{{ $game->moneyline_home }}</div>
                    </td>
                    <td>
                        <div style="font-size:12px;">{{ $game->spread_away }}</div>
                        <div style="font-size:12px;">{{ $game->spread_home }}</div>
                    </td>
                    <td>
                        <div style="font-size:12px;">{{ $game->total_over }}</div>
                        <div style="font-size:12px;">{{ $game->total_under }}</div>
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:6px;">
                            <div class="pct-bar"><div class="pct-fill pct-green" style="width:{{ $game->public_pct_home }}%"></div></div>
                            <span style="font-size:12px;font-weight:600;color:#22c55e;">{{ $game->public_pct_home }}%</span>
                        </div>
                    </td>
                    <td>
                        @if($game->money_pct_home)
                        <div style="display:flex;align-items:center;gap:6px;">
                            <div class="pct-bar"><div class="pct-fill pct-red" style="width:{{ $game->money_pct_home }}%"></div></div>
                            <span style="font-size:12px;font-weight:600;color:#ef4444;">{{ $game->money_pct_home }}%</span>
                        </div>
                        @else
                        <span style="color:#64748b;font-size:12px;">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;color:#64748b;">No consensus data available.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination">
            {{ $consensus->links('pagination::simple-tailwind') }}
        </div>
    </div>
</div>
@endsection
