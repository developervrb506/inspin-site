@extends('layouts.subscriber')
@section('title', 'Articles - INSPIN')
@section('page-title', 'Exclusive Articles')

@push('styles')
<style>
.art-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:18px; }
@media(max-width:1100px){ .art-grid { grid-template-columns:repeat(2,1fr); } }
@media(max-width:640px)  { .art-grid { grid-template-columns:1fr; } }

.art-card {
    background:#1a1a1a;
    border:1px solid rgba(255,252,238,.07);
    border-radius:12px; overflow:hidden;
    text-decoration:none; display:flex; flex-direction:column;
    transition:border-color .2s, transform .2s, box-shadow .2s;
    cursor:pointer;
}
.art-card:hover {
    border-color:rgba(253,181,21,.3);
    transform:translateY(-3px);
    box-shadow:0 12px 32px rgba(0,0,0,.5);
}
.art-card img { width:100%; height:170px; object-fit:cover; display:block; }
.art-card-placeholder { width:100%; height:170px; background:#212121; display:flex; align-items:center; justify-content:center; font-size:2rem; }
.art-card-body { padding:14px 16px 18px; display:flex; flex-direction:column; flex:1; }
.art-badge { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.4px; }
.art-title { font-family:'Clash Display',sans-serif; font-size:13.5px; font-weight:500; color:#FFFCEE; line-height:1.45; flex:1; margin-bottom:10px; }
.art-meta { display:flex; align-items:center; justify-content:space-between; padding-top:10px; border-top:1px solid rgba(255,252,238,.05); }
.art-author { display:flex; align-items:center; gap:7px; }
.art-avatar { width:22px; height:22px; border-radius:50%; background:#FDB515; color:#171818; display:flex; align-items:center; justify-content:center; font-size:9px; font-weight:800; flex-shrink:0; }
</style>
@endpush

@section('content')

{{-- Sport filter --}}
<div style="display:flex;gap:6px;flex-wrap:wrap;margin-bottom:20px;">
    @foreach([''=>'All','NFL'=>'NFL','NCAAF'=>'NCAAF','NBA'=>'NBA','NCAAB'=>'NCAAB','MLB'=>'MLB','NHL'=>'NHL'] as $val=>$label)
    <a href="/subscriber/articles{{ $val ? '?sport='.$val : '' }}"
       style="padding:7px 16px;border-radius:50px;font-size:12px;font-weight:600;text-decoration:none;
              border:1px solid {{ ($sport??'')===$val?'#FDB515':'#2d2d2d' }};
              color:{{ ($sport??'')===$val?'#FDB515':'#9a9a9a' }};
              background:{{ ($sport??'')===$val?'rgba(253,181,21,.05)':'transparent' }};
              transition:all .15s;">
        {{ $label }}
    </a>
    @endforeach
</div>

{{-- Article grid --}}
<div class="art-grid">
    @forelse($articles as $article)
    @php
        $sp = strtolower($article->sport ?? '');
        $tc = $sp==='mlb'?'#4ade80':($sp==='nba'?'#f87171':($sp==='nfl'?'#93c5fd':'#FDB515'));
        $bc = $sp==='mlb'?'rgba(22,163,74,.12)':($sp==='nba'?'rgba(220,38,38,.12)':($sp==='nfl'?'rgba(29,78,216,.12)':'rgba(253,181,21,.1)'));
    @endphp
    <a href="/subscriber/articles/{{ $article->slug }}" class="art-card">
        @if($article->featured_image)
            <img src="{{ asset('storage/'.$article->featured_image) }}" alt="{{ $article->title }}">
        @else
            <div class="art-card-placeholder">🏅</div>
        @endif
        <div class="art-card-body">
            <div style="display:flex;gap:6px;align-items:center;margin-bottom:8px;flex-wrap:wrap;">
                <span style="background:{{ $bc }};color:{{ $tc }};padding:2px 8px;border-radius:5px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;">{{ $article->sport }}</span>
                <span style="color:#24FBEE;font-size:10px;font-weight:600;border:1px solid rgba(36,251,238,.2);padding:1px 7px;border-radius:5px;background:rgba(36,251,238,.05);">{{ $article->category }}</span>
                @if($article->is_premium)
                <span style="color:#FDB515;font-size:9px;font-weight:700;border:1px solid rgba(253,181,21,.25);padding:1px 6px;border-radius:5px;">PREMIUM</span>
                @endif
            </div>
            <h3 class="art-title">{{ Str::limit($article->title, 80) }}</h3>
            @if($article->excerpt)
            <p style="font-size:12px;color:#6e6e6e;line-height:1.5;margin-bottom:10px;">{{ Str::limit(strip_tags($article->excerpt), 90) }}</p>
            @endif
            <div class="art-meta">
                <div class="art-author">
                    <div class="art-avatar">{{ strtoupper(substr($article->author ?? $article->expert_name ?? 'A', 0, 1)) }}</div>
                    <span style="font-size:11px;color:#6e6e6e;">{{ $article->author ?? $article->expert_name }}</span>
                </div>
                <span style="font-size:11px;color:#4a4a4a;">{{ $article->published_at?->format('M d, Y') }}</span>
            </div>
        </div>
    </a>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:56px 0;">
        <div style="font-size:2.5rem;margin-bottom:12px;">📰</div>
        <h3 style="color:#FFFCEE;margin-bottom:6px;font-weight:500;">No articles found</h3>
        <p style="color:#6e6e6e;font-size:13px;">Try a different sport filter.</p>
    </div>
    @endforelse
</div>

<div style="margin-top:28px;">{{ $articles->links() }}</div>
@endsection
