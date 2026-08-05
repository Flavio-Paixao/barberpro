@if ($paginator->hasPages())
<div style="display:flex;justify-content:center;align-items:center;gap:8px;margin-top:20px">
    @if ($paginator->onFirstPage())
        <span style="padding:8px 14px;background:#1a1a1a;color:#444;border-radius:6px;font-size:13px;cursor:not-allowed">←</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" style="padding:8px 14px;background:#1a1a1a;color:#fff;border-radius:6px;font-size:13px;text-decoration:none;border:1px solid #333">←</a>
    @endif
    @foreach ($elements as $element)
        @if (is_string($element))
            <span style="padding:8px 14px;color:#444;font-size:13px">...</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span style="padding:8px 14px;background:var(--accent, #C9A84C);color:#000;border-radius:6px;font-size:13px;font-weight:bold">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="padding:8px 14px;background:#1a1a1a;color:#fff;border-radius:6px;font-size:13px;text-decoration:none;border:1px solid #333">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" style="padding:8px 14px;background:#1a1a1a;color:#fff;border-radius:6px;font-size:13px;text-decoration:none;border:1px solid #333">→</a>
    @else
        <span style="padding:8px 14px;background:#1a1a1a;color:#444;border-radius:6px;font-size:13px;cursor:not-allowed">→</span>
    @endif
</div>
@endif
