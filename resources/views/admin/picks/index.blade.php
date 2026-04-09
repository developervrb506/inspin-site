@extends('admin.layouts.admin')

@section('title', 'Picks - INSPIN Admin')
@section('page-title', 'Picks')
@section('breadcrumb')
    <span>Picks</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>All Picks</h2>
        <a href="{{ route('admin.picks.create') }}" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M12 4v16m8-8H4"/></svg>
            New Pick
        </a>
    </div>
    <div class="card-body">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sport</th>
                        <th>Teams</th>
                        <th>Pick</th>
                        <th>Stars</th>
                        <th>Result</th>
                        <th>Expert</th>
                        <th>Date</th>
                        <th style="width:160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($picks as $pick)
                    <tr>
                        <td style="color:#94a3b8;">{{ $pick->id }}</td>
                        <td><span class="badge badge-{{ strtolower($pick->sport) }}">{{ $pick->sport }}</span></td>
                        <td>
                            <div style="font-weight:600;">{{ $pick->team1_name }} vs {{ $pick->team2_name }}</div>
                            <div style="font-size:12px;color:#94a3b8;">{{ $pick->venue ?? 'TBD' }}</div>
                        </td>
                        <td style="font-weight:600;color:#3b82f6;">{{ $pick->pick }}</td>
                        <td>
                            @if($pick->stars === 10)
                                <span style="color:#fbbf24;" title="Exclusive Whale Package">★★★★★★★★★★</span>
                            @else
                                <span style="color:#fbbf24;">{{ str_repeat('★', $pick->stars) }}{{ str_repeat('☆', 10 - ($pick->stars * 2)) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($pick->result === 'pending')
                                <span class="badge badge-neutral">Pending</span>
                            @elseif($pick->result === 'win')
                                <span class="badge badge-success">Win</span>
                            @elseif($pick->result === 'loss')
                                <span class="badge badge-danger">Loss</span>
                            @else
                                <span class="badge badge-warning">Push</span>
                            @endif
                        </td>
                        <td>{{ $pick->expert_name ?? '-' }}</td>
                        <td>
                            <div>{{ $pick->game_date?->format('M d, Y') ?? 'TBD' }}</div>
                            <div style="font-size:12px;color:#94a3b8;">{{ $pick->game_time?->format('h:i A') ?? '' }}</div>
                        </td>
                        <td style="white-space:nowrap;">
                            <a href="{{ route('admin.picks.edit', $pick) }}" class="btn btn-ghost btn-sm">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.picks.destroy', $pick) }}" style="display:inline;" onsubmit="return confirm('Delete this pick?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:14px;height:14px;"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div style="font-size:2rem;margin-bottom:8px;">🎯</div>
                                <h3>No picks yet</h3>
                                <p>Create your first pick to get started.</p>
                                <a href="{{ route('admin.picks.create') }}" class="btn btn-primary">Create Pick</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $picks->links() }}
    </div>
</div>
@endsection