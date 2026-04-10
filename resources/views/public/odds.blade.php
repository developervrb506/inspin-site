@extends('layouts.public')
@section('title', 'Live Odds - INSPIN')

@section('content')
<div class="section">
    <div class="container">
        <h1 class="section-title">Live Odds Comparison</h1>
        <p class="section-sub">Real-time odds from top sportsbooks</p>

        @if($consensus->count() > 0)
        <table class="c-table">
            <thead>
                <tr>
                    <th>Game</th>
                    <th>Moneyline</th>
                    <th>Spread</th>
                    <th>Total</th>
                    <th>Game Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($consensus as $game)
                <tr>
                    <td>
                        <div style="font-weight:600;color:#0f172a;">{{ $game->away_team }} @ {{ $game->home_team }}</div>
                        <div style="font-size:11px;color:#64748b;">{{ $game->league }}</div>
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
                    <td style="font-size:12px;color:#64748b;">{{ $game->game_date?->format('M d, g:i A') ?? 'TBD' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p style="color:#64748b;text-align:center;">No odds data available at this time.</p>
        @endif

        <div style="text-align:center;margin-top:24px;">
            <a href="{{ route('consensus') }}" class="btn btn-blue">View Consensus Data</a>
        </div>
    </div>
</div>
@endsection
