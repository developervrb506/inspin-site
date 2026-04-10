@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Contests</h1>
        @if (session('status'))
            <p>{{ session('status') }}</p>
        @endif
        <form method="GET" action="{{ route('modules.contests') }}">
            <input type="text" name="q" value="{{ $search }}" placeholder="Search name or type">
            <button type="submit">Search</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contests as $contest)
                    <tr>
                        <td>{{ $contest->id }}</td>
                        <td>{{ $contest->name }}</td>
                        <td>{{ $contest->contest_type }}</td>
                        <td>
                            <form method="POST" action="{{ route('modules.contests.status', $contest) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="q" value="{{ $search }}">
                                <input type="hidden" name="page" value="{{ $contests->currentPage() }}">
                                <select name="status">
                                    @foreach (['draft', 'active', 'paused', 'inactive', 'completed'] as $status)
                                        <option value="{{ $status }}" {{ $contest->status === $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No contests imported yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $contests->links() }}
    </div>
@endsection
