@extends('layouts.frontend.app')

@section('title', 'Search')

@section('content')

    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-home.css?v=4">
    <link rel="stylesheet" href="{{ asset('/') }}frontend/assets/css/eb-shop.css?v=1">

    @if($q !== '')
        <nav class="eb-crumb" aria-label="Breadcrumb">
            <div class="container">
                <a href="{{ route('homes') }}">Home</a>
                <span>/</span>
                <span>Search</span>
            </div>
        </nav>
    @endif

    <section class="eb-shop">
        <div class="container">

            @if($q !== '')
                <div class="eb-page-head">
                    <h1>Search results for "{{ $q }}"</h1>
                </div>
            @endif

            <section class="eb-image-search" id="image-search" aria-labelledby="image-search-title">
                <div>
                    <h2 id="image-search-title">Image Search</h2>
                    <p>Take a photo or upload an image to find similar items</p>
                </div>
                <form action="{{ route('searches.image') }}" method="POST" enctype="multipart/form-data" id="imageSearchForm">
                    @csrf
                    <label class="eb-image-upload" for="productImage"><span aria-hidden="true">▧</span><span>Take a photo or upload from library</span></label>
                    <input id="productImage" type="file" name="image" accept="image/jpeg,image/png,image/webp" capture="environment" required>
                    <button type="submit" id="submitImageSearch" hidden>Search image</button>
                    <div class="eb-image-selected" id="imageSelected" hidden><img id="imagePreview" alt=""><span id="imageFileName" aria-live="polite"></span><button type="button" id="clearProductImage" aria-label="Remove selected image">×</button></div>
                </form>
                @error('image') <p class="eb-image-error">{{ $message }}</p> @enderror
                @if(session('status')) <p>{{ session('status') }}</p> @endif
            </section>

            @if($q === '' || !empty($imageSearch))
                <section class="eb-search-categories" aria-labelledby="search-category-title">
                    <div class="eb-search-category-head">
                        <h2 id="search-category-title">Don't have an image? Try one of these:</h2>
                    </div>
                    <div class="eb-search-category-grid">
                        @foreach($imageCategories as $category)
                            <a class="eb-search-category-card" href="{{ route('categories.shop', ['category' => $category->slug]) }}" title="Browse {{ $category->name }}">
                                <span class="eb-search-category-image">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" loading="lazy">
                                    @else
                                        <span class="eb-search-category-placeholder" aria-hidden="true">{{ mb_substr($category->name, 0, 1) }}</span>
                                    @endif
                                </span>
                                <span class="eb-search-category-name">{{ $category->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

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
 .eb-search-categories{margin:0 0 28px}.eb-search-category-head{margin-bottom:12px}.eb-search-category-head h2{margin:0 0 4px;color:#172b52;font-size:18px;font-weight:700}.eb-search-category-head p{margin:0;color:#667085;font-size:13px}.eb-search-category-grid{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:12px}.eb-search-category-card{min-width:0;padding:8px;background:#fff;border:1px solid #edf0f4;border-radius:12px;color:#172b52;text-align:center;text-decoration:none;transition:transform .18s,border-color .18s,box-shadow .18s}.eb-search-category-card:hover{transform:translateY(-2px);border-color:#ffb17a;box-shadow:0 5px 16px rgba(23,43,82,.08);color:#f05a00}.eb-search-category-image{display:grid;place-items:center;aspect-ratio:1;background:#f3f4f6;border-radius:9px;overflow:hidden}.eb-search-category-image img{width:100%;height:100%;object-fit:contain}.eb-search-category-placeholder{display:grid;place-items:center;width:56px;height:56px;border-radius:50%;background:#e8ebf1;color:#172b52;font-size:25px;font-weight:700}.eb-search-category-name{display:block;margin-top:8px;font-size:12px;font-weight:600;line-height:1.3;overflow-wrap:anywhere}
/* Compact, centered image-search layout */
.eb-image-search{flex-direction:column;justify-content:flex-start;gap:12px;padding:22px 0 12px;margin-bottom:14px;background:transparent;border:0;border-radius:0;text-align:center}
.eb-image-search h2{font-size:20px;color:#222;font-weight:700}.eb-image-search p{font-size:14px;color:#444}
.eb-image-search form{grid-template-columns:minmax(0,1fr);width:min(100%,626px);min-width:0;margin:8px auto 0}
.eb-image-upload{width:100%;min-height:58px;border-radius:16px;background:linear-gradient(110deg,#ff9b52,#ff5b0b);font-size:15px}
.eb-image-search form #submitImageSearch{width:100%}
.eb-search-categories{margin:12px 0 26px}.eb-search-category-head h2{margin:0;color:#252525;font-size:16px;font-weight:500}.eb-search-category-head p{display:none}
@media(max-width:767px){.eb-image-search{align-items:stretch;flex-direction:column;padding:15px}.eb-image-search form{grid-template-columns:minmax(0,1fr);min-width:0;width:100%}.eb-image-upload,.eb-image-search button{width:100%;min-height:48px}.eb-page-head h1{font-size:20px;overflow-wrap:anywhere}}
@media(max-width:767px){.eb-search-category-grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:9px}.eb-search-category-card{padding:6px;border-radius:10px}.eb-search-category-name{font-size:11px}.eb-search-category-head h2{font-size:17px}}
</style>
@endpush

@push('scripts')
<script>
var imageInput=document.getElementById('productImage');var selectedImage=document.getElementById('imageSelected');var previewImage=document.getElementById('imagePreview');var previewUrl=null;
imageInput?.addEventListener('change',function(){var file=this.files?.[0];if(!file)return;if(previewUrl)URL.revokeObjectURL(previewUrl);previewUrl=URL.createObjectURL(file);previewImage.src=previewUrl;document.getElementById('imageFileName').textContent=file.name;selectedImage.hidden=false;document.getElementById('submitImageSearch').hidden=false;});
document.getElementById('clearProductImage')?.addEventListener('click',function(){imageInput.value='';selectedImage.hidden=true;document.getElementById('submitImageSearch').hidden=true;previewImage.removeAttribute('src');if(previewUrl)URL.revokeObjectURL(previewUrl);previewUrl=null;});
</script>
@endpush
