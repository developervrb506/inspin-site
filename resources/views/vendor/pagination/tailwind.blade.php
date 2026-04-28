@if ($paginator->hasPages())
@php
    $btn     = 'display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 12px;border-radius:8px;font-size:13px;font-weight:500;text-decoration:none;transition:all .18s;';
    $active  = $btn . 'background:#FDB515;border:1px solid #FDB515;color:#171818;font-weight:700;';
    $normal  = $btn . 'background:#212121;border:1px solid rgba(255,252,238,.1);color:#9a9a9a;';
    $disabled= $btn . 'background:#1a1a1a;border:1px solid rgba(255,252,238,.06);color:#3a3a3a;pointer-events:none;cursor:default;';
    $hover   = 'onmouseover="this.style.background=\'#2a2a2a\';this.style.borderColor=\'rgba(253,181,21,.3)\';this.style.color=\'#FFFCEE\'" onmouseout="this.style.background=\'#212121\';this.style.borderColor=\'rgba(255,252,238,.1)\';this.style.color=\'#9a9a9a\'"';
@endphp
<nav style="display:flex;gap:6px;justify-content:center;margin-top:32px;flex-wrap:wrap;align-items:center;">
    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span style="{{ $disabled }}">‹</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" style="{{ $normal }}" {!! $hover !!}>‹</a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span style="{{ $disabled }}">{{ $element }}</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span style="{{ $active }}">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="{{ $normal }}" {!! $hover !!}>{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" style="{{ $normal }}" {!! $hover !!}>›</a>
    @else
        <span style="{{ $disabled }}">›</span>
    @endif
</nav>
@endif
