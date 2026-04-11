@extends('admin.layouts.admin')

@section('title', ($pick->exists ? 'Edit' : 'Create') . ' Pick - INSPIN Admin')
@section('page-title', $pick->exists ? 'Edit Pick' : 'Create Pick')
@section('breadcrumb')
    <a href="{{ route('admin.picks.index') }}">Picks</a>
    <span class="sep">/</span>
    <span>{{ $pick->exists ? 'Edit' : 'Create' }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h2>{{ $pick->exists ? 'Edit Pick' : 'Create New Pick' }}</h2>
        <a href="{{ route('admin.picks.index') }}" class="btn btn-ghost">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Picks
        </a>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ $pick->exists ? route('admin.picks.update', $pick) : route('admin.picks.store') }}" enctype="multipart/form-data">
            @csrf
            @if($pick->exists) @method('PUT') @endif

            <h3 style="margin-bottom:20px;color:#0f172a;">Game Details</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="sport">Sport *</label>
                    <select id="sport" name="sport" required>
                        <option value="">Select sport</option>
                        @foreach($sports as $sport)
                            <option value="{{ $sport }}" {{ old('sport', $pick->sport) === $sport ? 'selected' : '' }}>
                                {{ $sport }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="game_date">Game Date *</label>
                    <input type="date" id="game_date" name="game_date" value="{{ old('game_date', $pick->game_date?->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label for="game_time">Game Time</label>
                    <input type="time" id="game_time" name="game_time" value="{{ old('game_time', $pick->game_time?->format('H:i')) }}">
                </div>
            </div>

            <h3 style="margin:30px 0 20px;color:#0f172a;">Teams</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="team1_preset">Quick Fill Team 1</label>
                    <select id="team1_preset" onchange="fillTeam1(this.value)">
                        <option value="">Type manually or select below...</option>
                        @foreach($teamLogos as $logo)
                            <option value="{{ $logo->id }}" data-name="{{ $logo->team_name }}" data-logo="{{ $logo->logo_path }}" data-abbr="{{ $logo->abbreviation }}">{{ $logo->sport }} - {{ $logo->team_name }}</option>
                        @endforeach
                    </select>
                    <div class="hint">Select a team to auto-fill name and logo</div>
                </div>
                <div class="form-group">
                    <label for="team2_preset">Quick Fill Team 2</label>
                    <select id="team2_preset" onchange="fillTeam2(this.value)">
                        <option value="">Type manually or select below...</option>
                        @foreach($teamLogos as $logo)
                            <option value="{{ $logo->id }}" data-name="{{ $logo->team_name }}" data-logo="{{ $logo->logo_path }}" data-abbr="{{ $logo->abbreviation }}">{{ $logo->sport }} - {{ $logo->team_name }}</option>
                        @endforeach
                    </select>
                    <div class="hint">Select a team to auto-fill name and logo</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="team1_name">Team 1 Name *</label>
                    <input type="text" id="team1_name" name="team1_name" value="{{ old('team1_name', $pick->team1_name) }}" placeholder="e.g., Alabama" required>
                </div>
                <div class="form-group">
                    <label for="team1_rotation">Team 1 Rotation #</label>
                    <input type="number" id="team1_rotation" name="team1_rotation" value="{{ old('team1_rotation', $pick->team1_rotation) }}" placeholder="e.g., 105">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="team2_name">Team 2 Name *</label>
                    <input type="text" id="team2_name" name="team2_name" value="{{ old('team2_name', $pick->team2_name) }}" placeholder="e.g., Georgia" required>
                </div>
                <div class="form-group">
                    <label for="team2_rotation">Team 2 Rotation #</label>
                    <input type="number" id="team2_rotation" name="team2_rotation" value="{{ old('team2_rotation', $pick->team2_rotation) }}" placeholder="e.g., 106">
                </div>
            </div>
            <div class="form-group">
                <label for="venue">Venue</label>
                <input type="text" id="venue" name="venue" value="{{ old('venue', $pick->venue) }}" placeholder="e.g., Bryant-Denny Stadium">
            </div>

            <h3 style="margin:30px 0 20px;color:#0f172a;">Pick Details</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="pick">Pick Recommendation *</label>
                    <input type="text" id="pick" name="pick" value="{{ old('pick', $pick->pick) }}" placeholder="e.g., Alabama -7.5" required>
                </div>
                <div class="form-group">
                    <label for="stars">Stars *</label>
                    <select id="stars" name="stars" required>
                        <option value="">Select stars</option>
                        @foreach([1,2,3,4,5,10] as $star)
                            <option value="{{ $star }}" {{ old('stars', $pick->stars) == $star ? 'selected' : '' }}>
                                {{ $star }}{{ $star === 10 ? ' (Exclusive Whale Package)' : '' }} star{{ $star > 1 ? 's' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <div class="hint">10-star picks are exclusive to Whale Package members</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="simulation_result">Simulation Result</label>
                    <select id="simulation_result" name="simulation_result">
                        <option value="">Not simulated</option>
                        @foreach(['Win', 'Loss', 'Push'] as $result)
                            <option value="{{ $result }}" {{ old('simulation_result', $pick->simulation_result) === $result ? 'selected' : '' }}>
                                {{ $result }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="result">Result</label>
                    <select id="result" name="result">
                        <option value="pending" {{ old('result', $pick->result ?? 'pending') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="win" {{ old('result', $pick->result) === 'win' ? 'selected' : '' }}>Win</option>
                        <option value="loss" {{ old('result', $pick->result) === 'loss' ? 'selected' : '' }}>Loss</option>
                        <option value="push" {{ old('result', $pick->result) === 'push' ? 'selected' : '' }}>Push</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="units">Units (stake)</label>
                    <input type="number" step="0.01" id="units" name="units" value="{{ old('units', $pick->units) }}" placeholder="e.g., 1.00">
                    <div class="hint">Number of units wagered on this pick</div>
                </div>
                <div class="form-group">
                    <label for="units_result">Unit Result (grade)</label>
                    <input type="number" step="0.01" id="units_result" name="units_result" value="{{ old('units_result', $pick->units_result) }}" placeholder="e.g., +3.00 or -2.00">
                    <div class="hint">Enter manually after grading. Win: +units, Loss: -units, Push: 0.00. Example: 3-star pick at +100 = +3.00</div>
                </div>
            </div>

            <h3 style="margin:30px 0 20px;color:#0f172a;">Expert & Article</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="expert_name">Expert</label>
                    <select id="expert_name" name="expert_name">
                        <option value="">Select expert</option>
                        @foreach($experts as $expert)
                            <option value="{{ $expert->name }}" {{ old('expert_name', $pick->expert_name) === $expert->name ? 'selected' : '' }}>
                                {{ $expert->name }}{{ $expert->specialty ? " ({$expert->specialty})" : '' }}
                            </option>
                        @endforeach
                    </select>
                    <div class="hint">Choose from active experts</div>
                </div>
                <div class="form-group">
                    <label for="related_article_id">Related Article</label>
                    <select id="related_article_id" name="related_article_id">
                        <option value="">None</option>
                        @foreach($articles as $article)
                            <option value="{{ $article->id }}" {{ old('related_article_id', $pick->related_article_id) == $article->id ? 'selected' : '' }}>
                                {{ Str::limit($article->title, 50) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="hint">Link to an existing article</div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:8px;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $pick->is_active ?? true) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#4f46e5;">
                        <span>Active</span>
                    </label>
                    <div class="hint">Only active picks appear on public site</div>
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:8px;">
                        <input type="checkbox" name="is_whale_exclusive" value="1" {{ old('is_whale_exclusive', $pick->is_whale_exclusive ?? false) ? 'checked' : '' }} style="width:18px;height:18px;accent-color:#4f46e5;">
                        <span>Whale Exclusive</span>
                    </label>
                    <div class="hint">Auto-checked when stars = 10</div>
                </div>
            </div>

            <h3 style="margin:30px 0 20px;color:#0f172a;">Team Logos</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="team1_logo">Team 1 Logo</label>
                    <input type="file" id="team1_logo" name="team1_logo" accept="image/*">
                    @if($pick->team1_logo)
                        <div style="margin-top:8px;">
                            <img src="{{ asset('storage/' . $pick->team1_logo) }}" alt="Team 1 logo" style="max-width:100px;max-height:60px;border-radius:4px;">
                            <div class="hint">Current logo. Upload new to replace.</div>
                        </div>
                    @endif
                    <div class="hint">JPEG, PNG, JPG, GIF, SVG. Max 2MB.</div>
                </div>
                <div class="form-group">
                    <label for="team2_logo">Team 2 Logo</label>
                    <input type="file" id="team2_logo" name="team2_logo" accept="image/*">
                    @if($pick->team2_logo)
                        <div style="margin-top:8px;">
                            <img src="{{ asset('storage/' . $pick->team2_logo) }}" alt="Team 2 logo" style="max-width:100px;max-height:60px;border-radius:4px;">
                            <div class="hint">Current logo. Upload new to replace.</div>
                        </div>
                    @endif
                    <div class="hint">JPEG, PNG, JPG, GIF, SVG. Max 2MB.</div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M5 13l4 4L19 7"/></svg>
                    {{ $pick->exists ? 'Update Pick' : 'Create Pick' }}
                </button>
                <a href="{{ route('admin.picks.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const starsSelect = document.getElementById('stars');
    const whaleCheckbox = document.querySelector('input[name="is_whale_exclusive"]');
    starsSelect.addEventListener('change', function() {
        if (this.value === '10') {
            whaleCheckbox.checked = true;
        }
    });

    // Filter team dropdowns by sport
    const sportSelect = document.getElementById('sport');
    if (sportSelect) {
        sportSelect.addEventListener('change', function() {
            const selectedSport = this.value;
            filterTeamDropdown('team1_preset', selectedSport);
            filterTeamDropdown('team2_preset', selectedSport);
            filterTeamDropdown('team1_name', selectedSport);
        });
        // Initial filter
        filterTeamDropdown('team1_preset', sportSelect.value);
        filterTeamDropdown('team2_preset', sportSelect.value);
    }
});

function filterTeamDropdown(selectId, sport) {
    const select = document.getElementById(selectId);
    if (!select) return;
    const options = select.querySelectorAll('option');
    options.forEach(function(opt) {
        if (opt.value === '') {
            opt.style.display = '';
            return;
        }
        const optSport = opt.textContent.split(' - ')[0];
        if (!sport || optSport === sport) {
            opt.style.display = '';
        } else {
            opt.style.display = 'none';
        }
    });
}

function fillTeam1(selectedValue) {
    if (!selectedValue) return;
    const select = document.getElementById('team1_preset');
    const opt = select.options[select.selectedIndex];
    if (opt && opt.value) {
        document.getElementById('team1_name').value = opt.dataset.name || '';
    }
}

function fillTeam2(selectedValue) {
    if (!selectedValue) return;
    const select = document.getElementById('team2_preset');
    const opt = select.options[select.selectedIndex];
    if (opt && opt.value) {
        document.getElementById('team2_name').value = opt.dataset.name || '';
    }
}
</script>
@endsection