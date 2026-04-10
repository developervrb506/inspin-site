@extends('layouts.public')
@section('title', 'Betting Trends - INSPIN')

@section('content')
<div class="section">
    <div class="container">
        <h1 class="section-title">Betting Trends & Hot Streaks</h1>
        <p class="section-sub">Track betting trends, winning streaks, and performance by sport</p>

        {{-- Hot Streaks Section --}}
        @if(!empty($hotStreaks) && count($hotStreaks) > 0)
        <div style="margin-bottom:40px;">
            <h2 style="color:#0f172a;margin-bottom:16px;">🔥 Hot Streaks</h2>
            <p style="color:#64748b;margin-bottom:20px;">Current winning streaks across all sports</p>
            <div class="grid grid-3" style="gap:16px;">
                @foreach($hotStreaks as $hot)
                <div class="card" style="border-left:4px solid #22c55e;">
                    <div class="card-body">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                            <span style="font-weight:700;font-size:1.1rem;">{{ $hot['sport'] }}</span>
                            <span style="background:#22c55e;color:white;padding:2px 8px;border-radius:99px;font-size:12px;font-weight:600;">🔥 {{ $hot['streak'] }}W Streak</span>
                        </div>
                        <div style="font-size:13px;color:#64748b;">
                            <div><strong>Period:</strong> {{ str_replace('_', ' ', ucfirst($hot['period'])) }}</div>
                            <div><strong>Win Rate:</strong> <span style="color:#22c55e;font-weight:600;">{{ $hot['win_rate'] }}%</span></div>
                            <div><strong>Record:</strong> {{ $hot['total_wins'] }}W - {{ $hot['total_losses'] }}L - {{ $hot['total_pushes'] }}P</div>
                            <div><strong>Units:</strong> <span style="color:{{ $hot['units'] >= 0 ? '#22c55e' : '#ef4444' }};font-weight:600;">{{ $hot['units'] >= 0 ? '+' : '' }}{{ number_format($hot['units'], 1) }}</span></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Streak Details by Sport --}}
        @if(!empty($streaks))
        <div style="margin-bottom:40px;">
            <h2 style="color:#0f172a;margin-bottom:16px;">📊 Streak Details by Sport</h2>
            <div style="overflow-x:auto;">
                <table class="c-table">
                    <thead>
                        <tr>
                            <th>Sport</th>
                            <th>Period</th>
                            <th>Current Streak</th>
                            <th>Best Streak</th>
                            <th>Win Rate</th>
                            <th>Record</th>
                            <th>Units</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($streaks as $sport => $periods)
                            @foreach($periods as $period => $data)
                            <tr>
                                <td><strong>{{ $sport }}</strong></td>
                                <td>{{ str_replace('_', ' ', ucfirst($period)) }}</td>
                                <td>{{ $data['current_streak'] }}W</td>
                                <td>{{ $data['best_streak'] }}W</td>
                                <td><span style="color:{{ $data['win_rate'] >= 50 ? '#22c55e' : '#ef4444' }};font-weight:600;">{{ $data['win_rate'] }}%</span></td>
                                <td>{{ $data['total_wins'] }}-{{ $data['total_losses'] }}-{{ $data['total_pushes'] }}</td>
                                <td><span style="color:{{ $data['total_units'] >= 0 ? '#22c55e' : '#ef4444' }};">{{ $data['total_units'] >= 0 ? '+' : '' }}{{ number_format($data['total_units'], 1) }}</span></td>
                                <td>
                                    @if($data['is_hot'])
                                        <span style="background:#22c55e;color:white;padding:2px 8px;border-radius:99px;font-size:11px;">🔥 HOT</span>
                                    @else
                                        <span style="background:#64748b;color:white;padding:2px 8px;border-radius:99px;font-size:11px;">--</span>
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

        {{-- Trend Cards --}}
        <div class="grid grid-2">
            <div class="card">
                <div class="card-body">
                    <h3>Public Betting Splits</h3>
                    <p>See what percentage of the public is betting on each side. Heavy public action can indicate sharp movement or public bias.</p>
                    <a href="{{ route('consensus') }}" class="btn btn-outline" style="margin-top:12px;">View Consensus</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Sharp vs Public</h3>
                    <p>When the money percentage differs significantly from the public percentage, sharps may be on the opposite side.</p>
                    <a href="{{ route('consensus') }}" class="btn btn-outline" style="margin-top:12px;">View Consensus</a>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>ATS Trends</h3>
                    <p>Against-the-spread records for teams and situations. Our simulation model tracks thousands of data points.</p>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3>Over/Under Trends</h3>
                    <p>Total betting trends and scoring patterns. Identify games where the total may be mispriced.</p>
                </div>
            </div>
        </div>

        <div style="text-align:center;margin-top:24px;">
            <a href="{{ route('join') }}" class="btn btn-red">Get Full Access to Trends Data</a>
        </div>
    </div>
</div>
@endsection
