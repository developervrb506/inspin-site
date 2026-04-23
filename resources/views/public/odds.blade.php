@extends('layouts.public')
@section('title', 'Live Odds - INSPIN')

@section('content')
<div class="section">
    <div class="container">
        <h1 class="section-title">Live Odds Comparison</h1>
        <p class="section-sub">Real-time odds from top sportsbooks</p>

        @if($consensus->count() > 0)
        <div style="overflow-x:auto;">
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
                            <div style="font-weight:600;color:#FFFCEE;">{{ $game->away_team }} @ {{ $game->home_team }}</div>
                            <div style="font-size:11px;color:#6e6e6e;margin-top:2px;">{{ $game->league }}</div>
                        </td>
                        <td>
                            <div style="font-size:13px;color:#9a9a9a;">{{ $game->moneyline_away }}</div>
                            <div style="font-size:13px;color:#9a9a9a;">{{ $game->moneyline_home }}</div>
                        </td>
                        <td>
                            <div style="font-size:13px;color:#9a9a9a;">{{ $game->spread_away }}</div>
                            <div style="font-size:13px;color:#9a9a9a;">{{ $game->spread_home }}</div>
                        </td>
                        <td>
                            <div style="font-size:13px;color:#9a9a9a;">{{ $game->total_over }}</div>
                            <div style="font-size:13px;color:#9a9a9a;">{{ $game->total_under }}</div>
                        </td>
                        <td style="font-size:13px;color:#6e6e6e;">{{ $game->game_date?->format('M d, g:i A') ?? 'TBD' }} ET</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="text-align:center;padding:60px 0;">
            <div style="font-size:3rem;margin-bottom:16px;">📊</div>
            <h3 style="color:#FFFCEE;margin-bottom:8px;">No odds data available</h3>
            <p style="color:#6e6e6e;">Check back soon for live odds.</p>
        </div>
        @endif

        <div style="text-align:center;margin-top:28px;">
            <a href="{{ route('consensus') }}" style="display:inline-block;padding:12px 32px;border:1px solid #FDB515;color:#FDB515;border-radius:50px;font-weight:600;text-decoration:none;transition:background .18s;" onmouseover="this.style.background='rgba(253,181,21,.1)'" onmouseout="this.style.background='transparent'">View Consensus Data →</a>
        </div>
    </div>
</div>
@endsection
