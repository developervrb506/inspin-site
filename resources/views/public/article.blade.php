@extends('layouts.public')
@section('title', $article->title . ' - INSPIN')

@section('content')
<div class="article-detail">
    <div style="display:flex;gap:6px;margin-bottom:12px;">
        <span class="badge badge-{{ strtolower($article->sport) }}">{{ $article->sport }}</span>
        <span class="badge badge-{{ $article->category }}">{{ $article->category }}</span>
        @if($article->is_premium)<span class="badge badge-premium">Premium</span>@endif
    </div>
    <h1>{{ $article->title }}</h1>
    <div class="meta">
        @if($article->expert_name)
            <span>By <strong>{{ $article->expert_name }}</strong></span>
        @elseif($article->author)
            <span>By {{ $article->author }}</span>
        @endif
        <span>{{ $article->published_at?->format('F d, Y') ?? '' }}</span>
    </div>
    @if($article->excerpt)
    <p style="color:#64748b;font-style:italic;border-left:3px solid #dc2626;padding-left:16px;margin-bottom:24px;">{{ $article->excerpt }}</p>
    @endif

    @if($article->featured_image)
    <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" style="width:100%;max-height:400px;object-fit:cover;border-radius:12px;margin-bottom:24px;">
    @endif

    @if($article->is_premium && (!auth()->check() || auth()->user()->role === 'free'))
        <div style="background:#f8fafc;border:2px solid #eab308;border-radius:8px;padding:32px;text-align:center;margin:24px 0;">
            <div style="font-size:2rem;margin-bottom:12px;">&#128274;</div>
            <h3 style="color:#0f172a;margin-bottom:8px;">Premium Content</h3>
            <p style="color:#64748b;margin-bottom:16px;">This article requires an active subscription to read.</p>
            <a href="{{ route('join') }}" class="btn btn-red">View Packages</a>
            @guest
            <p style="color:#64748b;margin-top:12px;font-size:13px;">Already a member? <a href="{{ route('login') }}">Login here</a></p>
            @endguest
        </div>
    @else
        <div class="content">
            {!! $article->content !!}
        </div>

        @php
            $relatedPicks = \App\Models\Pick::where('is_active', true)
                ->where('sport', $article->sport)
                ->orderBy('game_date', 'desc')
                ->limit(3)
                ->get();
        @endphp
        @if($relatedPicks->count() > 0)
        <div style="margin-top:32px;padding-top:24px;border-top:1px solid #e2e8f0;">
            <h2 style="color:#0f172a;margin-bottom:16px;">Related Picks</h2>
            <div class="grid grid-3" style="gap:12px;">
                @foreach($relatedPicks as $pick)
                <div class="card">
                    <div class="card-body">
                        <div style="display:flex;gap:6px;margin-bottom:6px;">
                            <span class="badge badge-{{ strtolower($pick->sport) }}">{{ $pick->sport }}</span>
                            @if($pick->result !== 'pending')
                                <span class="badge badge-{{ $pick->result === 'win' ? 'success' : ($pick->result === 'loss' ? 'danger' : 'neutral') }}">{{ ucfirst($pick->result) }}</span>
                            @endif
                            <span style="color:#fbbf24;">{{ str_repeat('★', $pick->stars) }}</span>
                        </div>
                        <div style="font-weight:600;font-size:0.95rem;margin-bottom:4px;">{{ $pick->team1_name }} vs {{ $pick->team2_name }}</div>
                        <div style="font-size:14px;color:#3b82f6;font-weight:600;">Pick: {{ $pick->pick }}</div>
                        @if($pick->expert_name)<div style="font-size:12px;color:#94a3b8;margin-top:4px;">By {{ $pick->expert_name }}</div>@endif
                        @if($pick->units !== null)<div style="font-size:12px;color:{{ $pick->units >= 0 ? '#22c55e' : '#ef4444' }};">{{ $pick->units >= 0 ? '+' : '' }}{{ number_format($pick->units, 2) }} units</div>@endif
                    </div>
                </div>
                @endforeach
            </div>
            <div style="text-align:center;margin-top:16px;">
                <a href="{{ route('picks') }}" class="btn btn-outline-dark">View All Picks</a>
            </div>
        </div>
        @endif
    @endif

    @if($related->count() > 0)
    <div style="margin-top:40px;padding-top:24px;border-top:1px solid #e2e8f0;">
        <h2 style="color:#0f172a;margin-bottom:16px;">Related Articles</h2>
        <div class="grid grid-3" style="gap:12px;">
            @foreach($related as $r)
            <a href="{{ route('article.show', $r) }}" class="card" style="text-decoration:none;">
                <div class="card-body">
                    <span class="badge badge-{{ strtolower($r->sport) }}">{{ $r->sport }}</span>
                    <h3 style="margin-top:6px;font-size:0.9rem;">{{ $r->title }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
