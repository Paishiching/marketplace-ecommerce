{{-- Home feature strip (4 Hours Delivery / Official Warranty ...). Text edit korte: config/home.php --}}
{{-- Auto slide (marquee) : CSS ache public/frontend/assets/css/eb-home.css te --}}
{{-- Card click korle policy page e jay. Alada page chaile config/home.php te 'route' => 'policy.xxx' dilen --}}
@php
    $features = array_values(config('home.features', []));
    $count    = count($features);

    // Ek group e kom pokkhe 6ta card rakhbo, jate wide screen e gap na thake
    $repeat   = $count ? (int) ceil(6 / $count) : 0;

    // Card songkha onujayi speed (card pro 8 second, boro number = aro slow)
    $duration = max(20, $count * 8);

    // Icon onujayi default policy page
    $iconRoute = [
        'truck' => 'policy.shipping',
        'van'   => 'policy.shipping',
        'badge' => 'policy.faq',
        'emi'   => 'policy.payment',
        'card'  => 'policy.payment',
    ];

    // Card er link : 1) config e 'route'  2) config e 'url'  3) icon er default
    $linkFor = function ($f) use ($iconRoute) {
        $name = $f['route'] ?? ($iconRoute[$f['icon'] ?? 'truck'] ?? 'policy.shipping');

        if (!empty($f['route']) || empty($f['url'])) {
            if (\Illuminate\Support\Facades\Route::has($name)) {
                return route($name);
            }
        }

        return $f['url'] ?? route('categories.shop');
    };

    $icon = function ($name) {
        switch ($name) {
            case 'badge':
                return '<path d="M12 3l7 3v5c0 4.5-3 8-7 10-4-2-7-5.5-7-10V6z"/><path d="M8.5 12l2.5 2.5 4.5-5"/>';
            case 'emi':
                return '<rect x="4" y="3.5" width="16" height="17" rx="2"/><path d="M12 3.5v17"/><path d="M8 8v3M16 8v3"/>';
            case 'van':
                return '<path d="M2 7h12v9H2z"/><path d="M14 10h4l3 3v3h-7z"/><circle cx="6.5" cy="17.5" r="1.7"/><circle cx="17" cy="17.5" r="1.7"/>';
            case 'card':
                return '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18"/><path d="M8 15l2 2 4-4"/>';
            default: // truck
                return '<path d="M1.5 9.5h3M0.5 12.5h4M2 15.5h2.5"/><path d="M6 6.5h8v10H6z"/><path d="M14 10h3.5l3 3v3.5H14z"/><circle cx="9" cy="17.5" r="1.7"/><circle cx="17.5" cy="17.5" r="1.7"/>';
        }
    };
@endphp

@if($count)
    <section class="eb-block">
        <div class="container">
            <div class="eb-feat-marquee" style="--feat-dur: {{ $duration }}s">
                <div class="eb-feat-track">

                    {{-- Group 1 (asol) + Group 2 (duplicate, seamless loop er jonno) --}}
                    @foreach([1, 2] as $group)
                        <div class="eb-feat-group" @if($group === 2) aria-hidden="true" @endif>
                            @for($r = 0; $r < $repeat; $r++)
                                @foreach($features as $idx => $f)
                                    <a href="{{ $linkFor($f) }}"
                                       class="eb-feat"
                                       @if($group === 2) tabindex="-1" @endif>
                                        <div class="eb-feat-txt">
                                            <h4>{{ $f['title'] ?? '' }}</h4>
                                            <p>{{ $f['text'] ?? '' }}</p>
                                        </div>

                                        <span class="eb-feat-ico {{ ($idx % 2 === 0) ? 'is-navy' : 'is-orange' }}">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                                {!! $icon($f['icon'] ?? 'truck') !!}
                                            </svg>
                                        </span>
                                    </a>
                                @endforeach
                            @endfor
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endif