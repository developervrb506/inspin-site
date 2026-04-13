@if ($paginator->hasPages())
<nav style="display:flex;gap:4px;justify-content:center;margin-top:24px;flex-wrap:wrap;">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span style="padding:6px 12px;border-radius:6px;font-size:12px;background:#fff;border:1px solid #e2e8f0;color:#cbd5e1;pointer-events:none;">
            &lsaquo;
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" style="padding:6px 12px;border-radius:6px;font-size:12px;background:#fff;border:1px solid #e2e8f0;color:#64748b;text-decoration:none;">
            &lsaquo;
        </a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <span style="padding:6px 12px;border-radius:6px;font-size:12px;background:#fff;border:1px solid #e2e8f0;color:#94a3b8;">{{ $element }}</span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span style="padding:6px 12px;border-radius:6px;font-size:12px;background:#4f46e5;border:1px solid #4f46e5;color:#fff;font-weight:600;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding:6px 12px;border-radius:6px;font-size:12px;background:#fff;border:1px solid #e2e8f0;color:#64748b;text-decoration:none;">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" style="padding:6px 12px;border-radius:6px;font-size:12px;background:#fff;border:1px solid #e2e8f0;color:#64748b;text-decoration:none;">
            &rsaquo;
        </a>
    @else
        <span style="padding:6px 12px;border-radius:6px;font-size:12px;background:#fff;border:1px solid #e2e8f0;color:#cbd5e1;pointer-events:none;">
            &rsaquo;
        </span>
    @endif
</nav>
@endif
