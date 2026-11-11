<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'vendor_id',
        'category_id',
        'sub_category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'price',
        'discount_price',
        'cost_price',
        'tags',
        'product_type',
        'thumbnail',
        'sponsored_video_url',
        'status',
        'is_new',
        'is_featured',
        'is_hot',
    ];

    // NOTE: 'status' ekhon string (draft/pending/published/rejected), tai boolean cast nei
    protected $casts = [
        'price'          => 'decimal:2',
        'discount_price' => 'decimal:2',
        'cost_price'     => 'decimal:2',
        'is_new'         => 'boolean',
        'is_featured'    => 'boolean',
        'is_hot'         => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot / Auto slug generation
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = static::generateUniqueSlug($product->name);
            }
        });
    }

    protected static function generateUniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeInStock($query)
    {
        return $query->whereHas('inventories', function ($q) {
            $q->where('quantity', '>', 0);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Badge Accessors & Scopes
    |--------------------------------------------------------------------------
    */
    public function getIsOnSaleAttribute(): bool
    {
        return ! is_null($this->discount_price) && $this->discount_price < $this->price;
    }

    public function scopeNewArrivals($query)
    {
        return $query->where('is_new', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeHot($query)
    {
        return $query->where('is_hot', true);
    }

    public function scopeOnSale($query)
    {
        return $query->whereNotNull('discount_price')
            ->whereColumn('discount_price', '<', 'price');
    }

    public function wholesaleListings()
    {
        return $this->hasMany(WholesaleProduct::class, 'product_id');
    }

    public function wholesaleListing()
    {
        return $this->hasOne(WholesaleProduct::class, 'product_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Display image (thumbnail -> primary image -> placeholder icon)
    | public/storage symlink thakuk ba na thakuk, storage/app/public e file
    | thakle /storage/... route diye serve hobe.
    |--------------------------------------------------------------------------
    */
    public function getDisplayImageAttribute(): string
    {
        $placeholder = asset('frontend/assets/images/imageIcon/image.jpg');

        $candidates = [$this->thumbnail];

        $primary = $this->relationLoaded('primaryImage')
            ? $this->primaryImage
            : $this->primaryImage()->first();

        if ($primary) {
            $candidates[] = $primary->image_path;
        }

        foreach ($candidates as $path) {
            if (empty($path)) {
                continue;
            }

            if (preg_match('#^https?://#i', $path)) {
                return $path;
            }

            $path = ltrim($path, '/');

            if (file_exists(public_path('storage/' . $path))
                || Storage::disk('public')->exists($path)) {
                return asset('storage/' . $path);
            }

            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        return $placeholder;
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    // All images belonging to this product
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id')->orderBy('sort_order');
    }

    // Convenience: just the one primary/thumbnail image
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id')->where('is_primary', true);
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    public function colorValues()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'product_attributes',
            'product_id',
            'attribute_value_id'
        )->whereHas('attribute', fn ($q) => $q->where('name', 'Color'));
    }

    public function sizeValues()
    {
        return $this->belongsToMany(
            AttributeValue::class,
            'product_attributes',
            'product_id',
            'attribute_value_id'
        )->whereHas('attribute', fn ($q) => $q->where('name', 'Size'));
    }

    public function warehouseProducts()
    {
        return $this->hasMany(WarehouseProduct::class, 'product_id');
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class, 'product_id');
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class, 'product_id');
    }

    public function supplierProducts()
    {
        return $this->hasMany(SupplierProduct::class, 'product_id');
    }

    public function wholesaleProducts()
    {
        return $this->hasMany(WholesaleProduct::class, 'product_id');
    }

    public function resellerProducts()
    {
        return $this->hasMany(ResellerProduct::class, 'product_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function wishlistItems()
    {
        return $this->hasMany(WishlistItem::class, 'product_id');
    }

    public function compareLists()
    {
        return $this->hasMany(CompareList::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function affiliateLinks()
    {
        return $this->hasMany(AffiliateLink::class, 'product_id');
    }

    public function campaignProducts()
    {
        return $this->hasMany(CampaignProduct::class, 'product_id');
    }

    public function flashSaleProducts()
    {
        return $this->hasMany(FlashSaleProduct::class, 'product_id');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_products', 'product_id', 'coupon_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function productVideos()
    {
        return $this->hasMany(ProductVideo::class, 'product_id');
    }

    public function productSpecifications()
    {
        return $this->hasMany(ProductSpecification::class, 'product_id')->orderBy('sort_order');
    }

    public function offerImages()
    {
        return $this->hasMany(ProductOfferImage::class, 'product_id')->orderBy('sort_order');
    }
}
