@extends('layouts.frontend.app')

@section('title', 'Search')

@section('content')

    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-home.css?v=3">
    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-shop.css?v=1">

    <nav class="eb-crumb" aria-label="Breadcrumb">
        <div class="container">
            <a href="{{ route('homes') }}">Home</a>
            <span>/</span>
            <span>Search</span>
        </div>
    </nav>

    <section class="eb-shop">
        <div class="container">

            <div class="eb-page-head">
                @if($q !== '')
                    <h1>Search results for "{{ $q }}"</h1>
                @else
                    <h1>Please enter a keyword to search</h1>
                @endif
            </div>

            <section class="eb-image-search" id="image-search" aria-labelledby="image-search-title">
                <div>
                    <h2 id="image-search-title">Find products by image</h2>
                    <p>Take a product photo or choose an image from your phone.</p>
                </div>
                <form action="{{ route('searches.image') }}" method="POST" enctype="multipart/form-data" id="imageSearchForm">
                    @csrf
                    <label class="eb-image-upload" for="productImage">📷 <span>Take a photo or choose an image</span></label>
                    <input id="productImage" type="file" name="image" accept="image/jpeg,image/png,image/webp" capture="environment" required>
                    <button type="submit">Search image</button>
                    <div class="eb-image-selected" id="imageSelected" hidden><img id="imagePreview" alt=""><span id="imageFileName" aria-live="polite"></span><button type="button" id="clearProductImage" aria-label="Remove selected image">×</button></div>
                </form>
                @error('image') <p class="eb-image-error">{{ $message }}</p> @enderror
                @if(session('status')) <p>{{ session('status') }}</p> @endif
            </section>

            @if(!empty($imageSearch))
                <div class="eb-bar"><p class="eb-count">Visually similar products ({{ $products->count() }})</p></div>
                @if($products->isEmpty()) <p class="eb-empty">No similar products found yet. Try a clearer photo or search by name.</p> @endif
            @endif

            @if($q !== '')
                <div class="eb-bar">
                    <p class="eb-count">{{ $products->total() }} Products</p>
                </div>
            @endif

            <div class="row eb-shop-row">
                @forelse($products as $product)
                    @include('frontend.categories.partials.product-list-item', ['product' => $product, 'colClass' => 'col-6 col-md-4 col-lg-3 eb-col-5'])
                @empty
                    @if($q !== '' && empty($imageSearch))
                        <div class="col-12">
                            <div class="eb-empty">No Products Found. Try a different keyword.</div>
                        </div>
                    @endif
                @endforelse
            </div>

            @if($products instanceof \Illuminate\Contracts\Pagination\Paginator || $products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                <div class="eb-pagi-wrap">{{ $products->onEachSide(1)->links('pagination.custom') }}</div>
            @endif

        </div>
    </section>

@endsection

@push('styles')
<style>
.eb-image-search{display:flex;align-items:center;justify-content:space-between;gap:18px;padding:18px;margin:0 0 22px;background:#fff;border:1px solid #e9edf3;border-radius:14px}
.eb-image-search h2{margin:0 0 4px;font-size:18px;color:#152b50}.eb-image-search p{margin:0;color:#667085;font-size:14px}
.eb-image-search form{display:grid;grid-template-columns:minmax(190px,1fr) auto;align-items:center;gap:10px;min-width:min(100%,340px)}.eb-image-upload{min-height:46px;padding:12px 18px;border:0;border-radius:10px;background:linear-gradient(135deg,#ff8a24,#f05a00);color:white;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;justify-content:center;gap:8px;white-space:nowrap;box-shadow:0 3px 9px rgba(240,90,0,.18);transition:filter .15s,transform .15s}.eb-image-upload:hover{filter:brightness(.97);transform:translateY(-1px)}.eb-image-search form input[type=file]{position:absolute;width:1px;height:1px;opacity:0;pointer-events:none}.eb-image-search button{min-height:46px;padding:12px 18px;border:0;border-radius:10px;background:#172b52;color:white;font-weight:700;cursor:pointer;white-space:nowrap}.eb-image-search button:hover{background:#243d70}.eb-image-search small{grid-column:1/-1;display:block;min-width:0;max-width:100%;color:#667085;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.eb-image-error{color:#b42318!important;width:100%}
.eb-image-search form .eb-image-selected{grid-column:1/-1;display:flex;align-items:center;gap:10px;min-width:0;width:100%;padding:8px 10px;border:1px solid #e5eaf1;border-radius:10px;background:#f8fafc}.eb-image-search form .eb-image-selected[hidden]{display:none}.eb-image-selected img{width:42px;height:42px;flex:0 0 42px;object-fit:cover;border-radius:6px}.eb-image-selected span{flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#344054;font-size:13px}.eb-image-search form .eb-image-selected button{flex:0 0 34px;width:34px;height:34px;min-height:34px;padding:0;border-radius:8px;background:#fff;border:1px solid #e5eaf1;color:#475467;font-size:21px;line-height:1}
.eb-image-search-link{display:grid;place-items:center;min-width:38px;color:#fd6801;text-decoration:none}.eb-image-search-link svg{width:21px;height:21px}
@media(max-width:767px){.eb-image-search{align-items:stretch;flex-direction:column;padding:15px}.eb-image-search form{grid-template-columns:minmax(0,1fr);min-width:0;width:100%}.eb-image-upload,.eb-image-search button{width:100%;min-height:48px}.eb-page-head h1{font-size:20px;overflow-wrap:anywhere}}
</style>
@endpush

@push('scripts')
<script>
var imageInput=document.getElementById('productImage');var selectedImage=document.getElementById('imageSelected');var previewImage=document.getElementById('imagePreview');var previewUrl=null;
imageInput?.addEventListener('change',function(){var file=this.files?.[0];if(!file)return;if(previewUrl)URL.revokeObjectURL(previewUrl);previewUrl=URL.createObjectURL(file);previewImage.src=previewUrl;document.getElementById('imageFileName').textContent=file.name;selectedImage.hidden=false;});
document.getElementById('clearProductImage')?.addEventListener('click',function(){imageInput.value='';selectedImage.hidden=true;previewImage.removeAttribute('src');if(previewUrl)URL.revokeObjectURL(previewUrl);previewUrl=null;});
</script>
@endpush
