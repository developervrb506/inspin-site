@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Modules</h1>
        <div class="metric">Picks: {{ $stats['picks'] ?? 0 }}</div>
        <div class="metric">Tickets: {{ $stats['support_tickets'] }}</div>
        <div class="metric">Contests: {{ $stats['contests'] }}</div>
        <ul class="list">
            <li><a href="{{ route('admin.picks.index') }}">View Picks</a></li>
            <li><a href="{{ route('modules.tickets') }}">View Tickets</a></li>
            <li><a href="{{ route('modules.contests') }}">View Contests</a></li>
        </ul>
    </div>
@endsection
