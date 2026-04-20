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

        @php $linkedPick = $article->relatedPicks->where('is_active', true)->first(); @endphp
        @if($linkedPick)
        <div style="margin-top:36px;padding-top:28px;border-top:2px solid #f59e0b;">
            <h2 style="color:#0f172a;margin-bottom:16px;font-size:1.2rem;font-weight:800;">Today's Pick for This Game</h2>
            <div style="background:linear-gradient(135deg,#09090b,#18181b);border-radius:14px;padding:24px;border:1px solid #27272a;">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-bottom:16px;">
                    <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                        <span style="background:rgba(30,58,95,0.8);color:#93c5fd;padding:3px 10px;border-radius:5px;font-size:11px;font-weight:700;border:1px solid rgba(147,197,253,0.15);">{{ $linkedPick->sport }}</span>
                        @php
                            $tStr = $linkedPick->game_time ? \Carbon\Carbon::parse($linkedPick->game_time)->format('H:i:s') : '00:00:00';
                            $gStart = \Carbon\Carbon::parse($linkedPick->game_date->format('Y-m-d') . ' ' . $tStr);
                            $pStatus = $linkedPick->result !== 'pending' ? 'GRADED' : ($gStart->isPast() ? 'LIVE' : 'UPCOMING');
                            $pColor = $pStatus === 'UPCOMING' ? '#4ade80' : ($pStatus === 'LIVE' ? '#fcd34d' : '#71717a');
                        @endphp
                        <span style="background:rgba(0,0,0,0.3);color:{{ $pColor }};border:1px solid {{ $pColor }}44;padding:3px 10px;border-radius:5px;font-size:10.5px;font-weight:700;">{{ $pStatus }}</span>
                    </div>
                    <div style="color:#f59e0b;font-size:15px;">
                        @if($linkedPick->stars === 10)
                            <span style="font-weight:800;font-size:12px;">★10 WHALE</span>
                        @else
                            {{ str_repeat('★', $linkedPick->stars) }}
                        @endif
                    </div>
                </div>

                <div style="font-size:1.1rem;font-weight:700;color:#fafafa;margin-bottom:6px;">
                    {{ $linkedPick->team1_name }} <span style="color:#52525b;font-size:13px;margin:0 6px;">vs</span> {{ $linkedPick->team2_name }}
                </div>
                <div style="color:#71717a;font-size:13px;margin-bottom:16px;">
                    {{ $linkedPick->game_date?->format('M d, Y') }}
                    {{ $linkedPick->game_time ? ' @ ' . \Carbon\Carbon::parse($linkedPick->game_time)->format('g:i A') . ' ET' : '' }}
                    @if($linkedPick->venue) · {{ $linkedPick->venue }} @endif
                </div>

                @auth
                <div style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.2);border-radius:10px;padding:14px 18px;margin-bottom:12px;">
                    <div style="font-size:10px;color:#f59e0b;text-transform:uppercase;font-weight:700;margin-bottom:4px;">The Pick</div>
                    <div style="font-size:1rem;font-weight:700;color:#fafafa;">{{ $linkedPick->pick }}</div>
                </div>
                @else
                <button onclick="openModal('join')" style="display:block;width:100%;padding:13px;background:linear-gradient(135deg,#ef4444,#dc2626);color:white;border:none;border-radius:10px;font-weight:700;cursor:pointer;font-size:15px;box-shadow:0 4px 14px rgba(220,38,38,0.3);">
                    View Pick — Login or Join Now
                </button>
                @endauth
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
