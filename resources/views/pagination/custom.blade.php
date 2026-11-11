@once
    <style>
        /* Pagination style (electronicsbangladesh theme). Ei file er bhitore, tai je page e use hobe shekhane-i kaj korbe */
        .eb-pagi{margin:0}
        .eb-pagi-list{list-style:none;margin:0;padding:0;display:flex;flex-wrap:wrap;justify-content:center;gap:6px}
        .eb-pagi-list li{margin:0;padding:0;list-style:none}
        .eb-pagi-list li a,
        .eb-pagi-list li span{min-width:38px;height:38px;padding:0 12px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;font-size:14px;font-weight:600;line-height:1;background:#fff;color:var(--eb-navy,#2a3582);border:1px solid var(--eb-line,rgba(42,53,130,.15));text-decoration:none;transition:all .2s}
        .eb-pagi-list li a:hover{background:var(--eb-orange,#fd6801);border-color:var(--eb-orange,#fd6801);color:#fff}
        .eb-pagi-list li a.active{background:var(--eb-navy,#2a3582);border-color:var(--eb-navy,#2a3582);color:#fff}
        .eb-pagi-list li span.disabled{opacity:.45}
        .eb-pagi-list li i{font-size:16px;line-height:1}
    </style>
@endonce

@if ($paginator->hasPages())
    <nav class="eb-pagi" role="navigation" aria-label="Pagination">
        <ul class="eb-pagi-list">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li><span class="prev disabled"><i class="ion-ios-arrow-left"></i></span></li>
            @else
                <li><a class="prev" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous"><i class="ion-ios-arrow-left"></i></a></li>
            @endif

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><a class="active" href="{{ $url }}" aria-current="page">{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li><a class="next" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next"><i class="ion-ios-arrow-right"></i></a></li>
            @else
                <li><span class="next disabled"><i class="ion-ios-arrow-right"></i></span></li>
            @endif

        </ul>
    </nav>
@endif