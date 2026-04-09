@extends('layouts.public')
@section('title', 'INSPIN - Sports Betting Analysis & Picks')

@section('content')
<div class="hero">
    <div class="container">
        <h1>INSPIN Simulation Model - <span>Up +150 Units</span> Over 3 Years</h1>
        <p>We simulate every NFL, NCAAF, NBA, NCAAB, NHL, and MLB game thousands of times. A $100 bettor would have netted $15,000+ profit. Get access to all our picks and start winning.</p>
        <div class="hero-actions">
            <a href="{{ route('join') }}" class="btn btn-red">Open a Package - From $99.99/mo</a>
            <a href="{{ route('articles') }}" class="btn btn-outline">Read Free Articles</a>
        </div>
    </div>
</div>

@if($articles->count() > 0)
<div class="section section-alt">
    <div class="container">
        <h2 class="section-title">Articles and Analysis</h2>
        <p class="section-sub">Expert picks, betting trends, and consensus analysis</p>
        <div class="grid grid-3">
            @foreach($articles as $article)
            <a href="{{ route('article.show', $article) }}" class="card" style="text-decoration:none;">
                <div class="card-body">
                    @if($article->featured_image)
                    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" style="width:100%;height:160px;object-fit:cover;border-radius:8px;margin-bottom:12px;">
                    @endif
                    <div style="display:flex;gap:6px;margin-bottom:8px;">
                        <span class="badge badge-{{ strtolower($article->sport) }}">{{ $article->sport }}</span>
                        <span class="badge badge-{{ $article->category }}">{{ $article->category }}</span>
                        @if($article->is_premium)<span class="badge badge-premium">Premium</span>@endif
                    </div>
                    <h3>{{ $article->title }}</h3>
                    <p>{{ Str::limit(strip_tags($article->excerpt), 120) }}</p>
                    <div class="card-meta">
                        <span>{{ $article->author }}</span>
                        <span>{{ $article->published_at?->format('M d, Y') ?? '' }}</span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:24px;">
            <a href="{{ route('articles') }}" class="btn btn-outline-dark">View All Articles</a>
        </div>
    </div>
</div>
@endif

@if($expertPicks->count() > 0)
<div class="section" style="background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%); color: white;">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <div>
                <h2 class="section-title" style="color:white;margin-bottom:4px;">🏈 EXPERT Picks</h2>
                <p style="color:#94a3b8;margin:0;">Today's top simulation picks</p>
            </div>
            <a href="{{ route('picks') }}" class="btn btn-outline" style="color:white;border-color:white;">View All Picks →</a>
        </div>

        <div id="picksCarousel" style="display:flex;gap:16px;overflow-x:auto;padding:10px 0;scroll-snap-type:x mandatory;">
            @foreach($expertPicks as $pick)
            <div class="pick-card" style="min-width:320px;background:#1e293b;border-radius:12px;padding:20px;scroll-snap-align:start;border:1px solid #334155;flex-shrink:0;">
                <!-- Header: Sport + Stars -->
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                    <span style="background:#3b82f6;color:white;padding:4px 12px;border-radius:4px;font-size:12px;font-weight:600;">{{ $pick->sport }}</span>
                    <span style="color:#fbbf24;font-size:14px;">
                        @if($pick->stars === 10)
                            <div style="text-align:center;">
                                <span>★★★★★★★★★★</span>
                                <div style="font-size:10px;margin-top:2px;">Exclusive Whale Package</div>
                            </div>
                        @else
                            {{ str_repeat('★', $pick->stars) }}{{ str_repeat('☆', 10 - ($pick->stars * 2)) }}
                        @endif
                    </span>
                </div>

                <!-- Teams -->
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
                    <div style="text-align:center;flex:1;">
                        @if($pick->team1_logo)
                        <img src="{{ asset('storage/' . $pick->team1_logo) }}" alt="{{ $pick->team1_name }}" style="width:48px;height:48px;object-fit:contain;margin-bottom:4px;">
                        @else
                        <div style="font-size:28px;margin-bottom:4px;">🏈</div>
                        @endif
                        <div style="font-weight:600;font-size:14px;">{{ $pick->team1_name }}</div>
                        <div style="font-size:11px;color:#64748b;">#{{ $pick->team1_rotation }}</div>
                    </div>
                    <div style="color:#64748b;font-size:12px;padding:0 12px;">VS</div>
                    <div style="text-align:center;flex:1;">
                        @if($pick->team2_logo)
                        <img src="{{ asset('storage/' . $pick->team2_logo) }}" alt="{{ $pick->team2_name }}" style="width:48px;height:48px;object-fit:contain;margin-bottom:4px;">
                        @else
                        <div style="font-size:28px;margin-bottom:4px;">🏈</div>
                        @endif
                        <div style="font-weight:600;font-size:14px;">{{ $pick->team2_name }}</div>
                        <div style="font-size:11px;color:#64748b;">#{{ $pick->team2_rotation }}</div>
                    </div>
                </div>

                <!-- Game Info -->
                <div style="background:#0f172a;border-radius:8px;padding:10px;margin-bottom:12px;font-size:12px;color:#94a3b8;">
                    <div style="display:flex;justify-content:space-between;">
                        <span>{{ $pick->game_date->format('M d, Y') }}</span>
                        <span>{{ $pick->game_time ?? 'TBD' }}</span>
                    </div>
                    <div style="margin-top:4px;color:#64748b;">{{ $pick->venue ?? 'TBD' }}</div>
                </div>

                <!-- Pick -->
                <div style="background:#1e40af;border-radius:8px;padding:12px;margin-bottom:12px;text-align:center;">
                    <div style="font-size:11px;color:#93c5fd;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Pick</div>
                    <div style="font-size:18px;font-weight:700;color:white;">{{ $pick->pick }}</div>
                </div>

                <!-- Simulate Button -->
                <button onclick="simulatePick({{ $pick->id }})" class="btn btn-red" style="width:100%;font-size:14px;">
                    🎲 SIMULATE
                </button>
            </div>
            @endforeach
        </div>

        <!-- Carousel Navigation -->
        <div style="display:flex;justify-content:center;gap:8px;margin-top:16px;">
            <button onclick="document.getElementById('picksCarousel').scrollBy({left:-340,behavior:'smooth'})" style="background:#334155;border:none;color:white;padding:8px 16px;border-radius:6px;cursor:pointer;">← Prev</button>
            <button onclick="document.getElementById('picksCarousel').scrollBy({left:340,behavior:'smooth'})" style="background:#334155;border:none;color:white;padding:8px 16px;border-radius:6px;cursor:pointer;">Next →</button>
        </div>
    </div>
</div>
@endif



<div class="section section-alt">
    <div class="container">
        <h2 class="section-title">Membership Packages</h2>
        <p class="section-sub">Get access to all INSPIN simulation picks for as little as $99.99/month</p>
        <div style="display:grid;grid-template-columns:1fr 300px;gap:24px;">
            <div class="grid grid-3" style="grid-template-columns:1fr 1fr;">
                @foreach($packages as $pkg)
                <div class="pkg-card {{ $pkg->slug === 'quarterly' ? 'featured' : '' }}">
                    <h3>{{ $pkg->name }}</h3>
                    <div class="pkg-price"><sup>$</sup>{{ number_format($pkg->price, 0) }}</div>
                    <div class="pkg-duration">{{ $pkg->duration }} Access</div>
                    <ul class="pkg-features">
                        @foreach(($pkg->features ?? []) as $feature)
                        <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('register') }}" class="btn {{ $pkg->slug === 'quarterly' ? 'btn-red' : 'btn-blue' }}" style="width:100%;">Get Started</a>
                </div>
                @endforeach
            </div>
            @if($whalePackages->count() > 0)
            <div>
                @foreach($whalePackages as $whale)
                <a href="{{ route('join') }}" class="card" style="text-decoration:none;display:block;">
                    <div class="card-body" style="text-align:center;">
                        <div style="font-size:2rem;margin-bottom:8px;">🐋</div>
                        <h3 style="color:#d97706;">{{ $whale->title }}</h3>
                        <div style="font-size:1.5rem;font-weight:800;color:#0f172a;margin:8px 0;">${{ number_format($whale->price, 0) }}</div>
                        <div style="font-size:12px;color:#64748b;margin-bottom:12px;">{{ $whale->duration }} Access</div>
                        <div class="btn btn-red" style="width:100%;">Learn More</div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <h2 class="section-title">Sports We Cover</h2>
        <p class="section-sub">Expert handicapping for all major US sports</p>
        <div class="grid grid-3">
            <div class="card" style="text-align:center;padding:24px;">
                <div style="font-size:2.5rem;margin-bottom:8px;">🏈</div>
                <h3>NFL</h3>
                <p>Weekly picks, playoff analysis, Super Bowl predictions</p>
            </div>
            <div class="card" style="text-align:center;padding:24px;">
                <div style="font-size:2.5rem;margin-bottom:8px;">🏈</div>
                <h3>NCAAF</h3>
                <p>College football picks, bowl games, championship analysis</p>
            </div>
            <div class="card" style="text-align:center;padding:24px;">
                <div style="font-size:2.5rem;margin-bottom:8px;">🏀</div>
                <h3>NBA</h3>
                <p>Daily picks, consensus data, simulation model</p>
            </div>
            <div class="card" style="text-align:center;padding:24px;">
                <div style="font-size:2.5rem;margin-bottom:8px;">🏀</div>
                <h3>NCAAB</h3>
                <p>March Madness, college basketball picks and trends</p>
            </div>
            <div class="card" style="text-align:center;padding:24px;">
                <div style="font-size:2.5rem;margin-bottom:8px;">⚾</div>
                <h3>MLB</h3>
                <p>162-game season picks, playoff tracking</p>
            </div>
            <div class="card" style="text-align:center;padding:24px;">
                <div style="font-size:2.5rem;margin-bottom:8px;">🏒</div>
                <h3>NHL</h3>
                <p>Stanley Cup picks, goalie analysis, trends</p>
            </div>
        </div>
    </div>
</div>

<div class="section section-alt">
    <div class="container">
        <div class="cta">
            <h2>Start Winning with INSPIN Today</h2>
            <p>Our simulation model has been up over 150 units in the last 3 years. Don't miss out.</p>
            <a href="{{ route('join') }}" class="btn">Open a Package Now</a>
        </div>
    </div>
</div>

<!-- Simulation Modal -->
<div id="simulateModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.7);z-index:9999;display:none;align-items:center;justify-content:center;">
    <div style="background:white;border-radius:16px;padding:32px;max-width:400px;text-align:center;">
        <h3 id="modalTitle" style="margin-bottom:8px;">Simulation Result</h3>
        <p id="modalResult" style="font-size:24px;font-weight:bold;margin:16px 0;"></p>
        <p id="modalMessage" style="color:#64748b;margin-bottom:20px;"></p>
        <button onclick="closeModal()" class="btn btn-blue" style="width:100%;">Close</button>
    </div>
</div>

<script>
function simulatePick(pickId) {
    @auth
        fetch('/picks/' + pickId + '/simulate', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            showModal(data.simulation_result, data.message || '');
        })
        .catch(error => {
            console.error('Error:', error);
            showModal('Error', 'Something went wrong. Please try again.');
        });
    @else
        showLoginPopup();
    @endauth
}

function showModal(result, message) {
    var modal = document.getElementById('simulateModal');
    var title = document.getElementById('modalTitle');
    var resultEl = document.getElementById('modalResult');
    var messageEl = document.getElementById('modalMessage');

    if (result === 'Win') {
        title.textContent = 'Simulation Result';
        resultEl.textContent = 'WIN!';
        resultEl.style.color = '#22c55e';
    } else if (result === 'Loss') {
        title.textContent = 'Simulation Result';
        resultEl.textContent = 'LOSS';
        resultEl.style.color = '#ef4444';
    } else if (result === 'Push') {
        title.textContent = 'Simulation Result';
        resultEl.textContent = 'PUSH';
        resultEl.style.color = '#eab308';
    } else {
        title.textContent = 'Simulation Result';
        resultEl.textContent = result;
        resultEl.style.color = '#1e293b';
    }
    
    messageEl.textContent = message || '';
    modal.style.display = 'flex';
}

function closeModal() {
    document.getElementById('simulateModal').style.display = 'none';
}

function showLoginPopup() {
    // Try to open modal if available
    if (typeof openModal === 'function') {
        openModal();
    } else {
        window.location.href = '/login?redirect=' + encodeURIComponent(window.location.pathname);
    }
}

document.getElementById('simulateModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>
@endsection
