{{-- Shop / category / search page er product item. Bootstrap column wrapper rakha hoyeche,
     tai je jaygay @include kora ache (row er bhitore) shekhane o kaj korbe.
     Column size bodlate: @include(..., ['product' => $product, 'colClass' => 'col-6 col-md-4']) --}}
@php $colClass = $colClass ?? 'col-6 col-sm-6 col-md-4 col-xl-3'; @endphp

<div class="{{ $colClass }} eb-shop-col">
    @include('frontend.partials.product-card', ['product' => $product])
</div>