@extends('layouts.public')
@section('title', $article->title . ' - INSPIN')

@section('content')
<div class="article-detail">
    <div style="display:flex;gap:8px;margin-bottom:14px;flex-wrap:wrap;">
        @php $sp=strtolower($article->sport??'');$bc=$sp==='mlb'?'rgba(22,163,74,.15)':($sp==='nba'?'rgba(220,38,38,.15)':($sp==='nfl'?'rgba(29,78,216,.15)':'rgba(253,181,21,.12)'));$tc=$sp==='mlb'?'#4ade80':($sp==='nba'?'#f87171':($sp==='nfl'?'#93c5fd':'#FDB515')); @endphp
        <span style="background:{{ $bc }};color:{{ $tc }};padding:3px 10px;border-radius:5px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;">{{ $article->sport }}</span>
        <span style="background:rgba(36,251,238,.1);border:1px solid rgba(36,251,238,.25);color:#24FBEE;padding:3px 10px;border-radius:5px;font-size:10px;font-weight:600;">{{ $article->category }}</span>
        @if($article->is_premium)<span style="background:rgba(253,181,21,.12);color:#FDB515;padding:3px 10px;border-radius:5px;font-size:10px;font-weight:700;">PREMIUM</span>@endif
    </div>

    <h1>{{ $article->title }}</h1>

    <div class="meta">
        @if($article->expert_name)
            <span style="color:#9a9a9a;">By <strong style="color:#FFFCEE;">{{ $article->expert_name }}</strong></span>
        @elseif($article->author)
            <span style="color:#9a9a9a;">By <strong style="color:#FFFCEE;">{{ $article->author }}</strong></span>
        @endif
        <span style="color:#4a4a4a;">{{ $article->published_at?->format('F d, Y') ?? '' }} ET</span>
    </div>

    @if($article->excerpt)
    <p style="color:#9a9a9a;font-style:italic;border-left:3px solid #FDB515;padding-left:16px;margin-bottom:24px;">{{ $article->excerpt }}</p>
    @endif

    @if($article->featured_image)
    <img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title }}" style="width:100%;max-height:420px;object-fit:cover;border-radius:12px;margin-bottom:28px;border:1px solid rgba(255,252,238,.08);">
    @endif

    @if($article->is_premium && (!auth()->check() || auth()->user()->role === 'free'))
        <div style="background:#212121;border:1px solid rgba(253,181,21,.2);border-radius:12px;padding:36px;text-align:center;margin:24px 0;">
            <div style="font-size:2.5rem;margin-bottom:14px;">🔒</div>
            <h3 style="color:#FFFCEE;margin-bottom:8px;font-family:'Clash Display',sans-serif;font-weight:500;">Premium Content</h3>
            <p style="color:#6e6e6e;margin-bottom:20px;">This article requires an active subscription to read.</p>
            <a href="{{ route('join') }}" style="display:inline-block;padding:12px 32px;background:#FDB515;color:#171818;border-radius:50px;font-weight:700;text-decoration:none;box-shadow:0 0 20px rgba(253,181,21,.3);">View Packages</a>
            @guest
            <p style="color:#4a4a4a;margin-top:14px;font-size:13px;">Already a member? <button onclick="openModal()" style="background:none;border:none;color:#FDB515;cursor:pointer;font-size:13px;font-weight:600;">Login here</button></p>
            @endguest
        </div>
    @else
        <div class="content">
            {!! $article->content !!}
        </div>

        @php $linkedPick = $article->relatedPicks->where('is_active', true)->first(); @endphp
        @if($linkedPick)
        <div style="margin-top:36px;padding-top:28px;border-top:1px solid rgba(253,181,21,.2);">
            <h2 style="color:#FFFCEE;margin-bottom:16px;font-size:1.2rem;font-family:'Clash Display',sans-serif;font-weight:500;">Today's Pick for This Game</h2>
            <div style="background:#212121;border-radius:12px;padding:24px;border:1px solid rgba(253,181,21,.15);">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;flex-wrap:wrap;gap:12px;margin-bottom:14px;">
                    <div style="display:flex;gap:8px;align-items:center;">
                        @php
                            $tStr=$linkedPick->game_time?\Carbon\Carbon::parse($linkedPick->game_time)->format('H:i:s'):'00:00:00';
                            $gStart=\Carbon\Carbon::parse($linkedPick->game_date->format('Y-m-d').' '.$tStr);
                            $pStatus=$linkedPick->result!=='pending'?'GRADED':($gStart->isPast()?'LIVE':'UPCOMING');
                            $pColor=$pStatus==='UPCOMING'?'#00D15B':($pStatus==='LIVE'?'#ef4444':'#4a4a4a');
                        @endphp
                        <span style="background:rgba(253,181,21,.1);color:#FDB515;padding:3px 10px;border-radius:5px;font-size:11px;font-weight:700;">{{ $linkedPick->sport }}</span>
                        <span style="color:{{ $pColor }};font-size:11px;font-weight:700;">{{ $pStatus }}</span>
                    </div>
                    <div style="color:#FDB515;font-size:16px;">
                        @if($linkedPick->stars===10)<span style="font-weight:800;font-size:12px;">★10 WHALE</span>
                        @else{{ str_repeat('★',$linkedPick->stars) }}@endif
                    </div>
                </div>
                <div style="font-size:1.1rem;font-weight:600;color:#FFFCEE;margin-bottom:6px;font-family:'Clash Display',sans-serif;">
                    {{ $linkedPick->team1_name }} <span style="color:#4a4a4a;font-size:13px;margin:0 6px;">vs</span> {{ $linkedPick->team2_name }}
                </div>
                <div style="color:#6e6e6e;font-size:13px;margin-bottom:16px;">
                    {{ $linkedPick->game_date?->format('M d, Y') }}{{ $linkedPick->game_time?' @ '.\Carbon\Carbon::parse($linkedPick->game_time)->format('g:i A').' ET':'' }}@if($linkedPick->venue) · {{ $linkedPick->venue }}@endif
                </div>
                @auth
                <div style="background:rgba(253,181,21,.06);border:1px solid rgba(253,181,21,.15);border-radius:10px;padding:14px 18px;">
                    <div style="font-size:10px;color:#FDB515;text-transform:uppercase;font-weight:700;margin-bottom:4px;letter-spacing:.4px;">The Pick</div>
                    <div style="font-size:1rem;font-weight:600;color:#FFFCEE;">{{ $linkedPick->pick }}</div>
                </div>
                @else
                <button onclick="openModal('join')" style="display:block;width:100%;padding:13px;background:#FDB515;color:#171818;border:none;border-radius:50px;font-weight:700;cursor:pointer;font-size:15px;box-shadow:0 0 20px rgba(253,181,21,.3);">
                    View Pick — Login or Join Now
                </button>
                @endauth
            </div>
        </div>
        @endif
    @endif

    @if($related->count() > 0)
    <div style="margin-top:48px;padding-top:28px;border-top:1px solid rgba(255,252,238,.06);">
        <h2 style="color:#FFFCEE;margin-bottom:20px;font-family:'Clash Display',sans-serif;font-weight:500;">Related Articles</h2>
        <div class="grid grid-3" style="gap:16px;">
            @foreach($related as $r)
            <a href="{{ route('article.show', $r) }}" style="text-decoration:none;background:#212121;border:1px solid rgba(255,252,238,.08);border-radius:10px;padding:16px;transition:border-color .2s;" onmouseover="this.style.borderColor='rgba(253,181,21,.3)'" onmouseout="this.style.borderColor='rgba(255,252,238,.08)'">
                @php $sp2=strtolower($r->sport??'');$bc2=$sp2==='mlb'?'rgba(22,163,74,.15)':($sp2==='nba'?'rgba(220,38,38,.15)':($sp2==='nfl'?'rgba(29,78,216,.15)':'rgba(253,181,21,.12)'));$tc2=$sp2==='mlb'?'#4ade80':($sp2==='nba'?'#f87171':($sp2==='nfl'?'#93c5fd':'#FDB515')); @endphp
                <span style="background:{{ $bc2 }};color:{{ $tc2 }};padding:2px 8px;border-radius:4px;font-size:10px;font-weight:700;text-transform:uppercase;">{{ $r->sport }}</span>
                <h3 style="margin-top:8px;font-size:13px;color:#FFFCEE;line-height:1.4;font-weight:500;font-family:'Clash Display',sans-serif;">{{ Str::limit($r->title, 60) }}</h3>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
