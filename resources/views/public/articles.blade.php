@extends('layouts.public')
@section('title', 'Articles - INSPIN')

@section('content')
<div class="section">
    <div class="container">
        <h1 class="section-title">Articles & Analysis</h1>
        <p class="section-sub">Expert sports betting articles, consensus analysis, and betting trends</p>

        <div class="sport-filter">
            <a href="{{ route('articles') }}" class="{{ !$sport ? 'active' : '' }}">All</a>
            <a href="{{ route('articles', ['sport' => 'NFL']) }}" class="{{ $sport === 'NFL' ? 'active' : '' }}">NFL</a>
            <a href="{{ route('articles', ['sport' => 'NBA']) }}" class="{{ $sport === 'NBA' ? 'active' : '' }}">NBA</a>
            <a href="{{ route('articles', ['sport' => 'MLB']) }}" class="{{ $sport === 'MLB' ? 'active' : '' }}">MLB</a>
            <a href="{{ route('articles', ['sport' => 'NHL']) }}" class="{{ $sport === 'NHL' ? 'active' : '' }}">NHL</a>
        </div>

        <div class="grid grid-3">
            @forelse($articles as $article)
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
            @empty
            <p style="color:#64748b;grid-column:1/-1;text-align:center;">No articles found.</p>
            @endforelse
        </div>

        <div class="pagination">
            {{ $articles->links('pagination::simple-tailwind') }}
        </div>
    </div>
</div>
@endsection
