{{-- =====================================================================
     Home page SEO content block (footer er thik upore)
     - Boro heading (<h1>)    : niche "TITLE" likha line
     - Choto heading (<h2>)   : "SUB TITLE" likha line
     - Text / link / list     : sob ekhanei edit korben
     Category link: slug onujayi ('television' er jaygay apnar category slug dien)
     ===================================================================== --}}
@php
    $store = $site->site_name ?? config('app.name', 'Our Store');
    $cat   = fn ($slug) => route('categories.shop', ['category' => $slug]);
@endphp

<section class="eb-seo">
    <div class="container">

        {{-- TITLE (main heading) --}}
        <h1>{{ $store }} – Trusted Online Electronics Shop in Bangladesh</h1>

        <p>
            Looking for electronics without moving from shop to shop?
            <strong>{{ $store }}</strong> brings mobile phones, televisions, large appliances and kitchen essentials
            together in one convenient online store. Explore current models, compare specifications and choose
            products that suit your home, office and budget.
        </p>
        <p>
            We focus on competitive prices, genuine products, reliable delivery and helpful customer support,
            so buying electronics online stays simple and dependable.
        </p>

        {{-- SUB TITLE --}}
        <h2>Shop Electronics and Home Appliances in One Place</h2>

        <p>
            Every household has different priorities. A family may need a larger refrigerator and washing machine,
            while a student may be searching for an affordable smartphone. Our clearly organised categories help you
            browse by product type, brand, features and budget.
        </p>

        <ul>
            <li><a href="{{ $cat('smartphones') }}">Mobile phones</a> – everyday communication, photography, gaming and work.</li>
            <li><a href="{{ $cat('television') }}">Televisions</a> – compare screen sizes, resolutions and smart platforms.</li>
            <li><a href="{{ $cat('air-conditioner') }}">Air conditioners</a> – cooling options for bedrooms, living rooms and offices.</li>
            <li><a href="{{ $cat('refrigerator') }}">Refrigerators and freezers</a> – different capacities, door styles and cooling systems.</li>
            <li><a href="{{ $cat('washing-machine') }}">Washing machines</a> – top-load and front-load models for every family size.</li>
            <li><a href="{{ $cat('kitchen-appliances') }}">Kitchen appliances</a> – practical products for cooking and food preparation.</li>
            <li><a href="{{ $cat('small-appliances') }}">Small appliances</a> – everyday products for comfort, cleaning and convenience.</li>
        </ul>

        <p>
            We also feature <a href="{{ $cat('soundbar') }}">soundbars</a> and
            <a href="{{ $cat('lifestyle') }}">lifestyle products</a> for a more connected and comfortable routine.
        </p>

    </div>
</section>