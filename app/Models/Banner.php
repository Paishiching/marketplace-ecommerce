<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';

    /**
     * Banner placement list. Frontend e ei key diye query korbe.
     */
    public const POSITIONS = [
        'hero_main' => [
            'group' => 'Hero Section',
            'label' => 'Hero - Main Slider',
            'size'  => '880 × 405 px',
            'note'  => 'Boro main banner. Ekadhik banner dile auto slider hobe.',
        ],
        'hero_side_top' => [
            'group' => 'Hero Section',
            'label' => 'Hero - Side Top',
            'size'  => '430 × 195 px',
            'note'  => 'Main slider er dane upore. Sudhu 1ta banner dekhabe.',
        ],
        'hero_side_bottom' => [
            'group' => 'Hero Section',
            'label' => 'Hero - Side Bottom',
            'size'  => '430 × 195 px',
            'note'  => 'Main slider er dane niche. Sudhu 1ta banner dekhabe.',
        ],
        'promo_strip' => [
            'group' => 'Promo Strip',
            'label' => 'Promo Strip (Wide)',
            'size'  => '1318 × 160 px',
            'note'  => 'Full width lomba patla banner. Sudhu 1ta banner dekhabe.',
        ],
        'dual_left' => [
            'group' => 'Dual Banner',
            'label' => 'Dual - Left',
            'size'  => '645 × 330 px',
            'note'  => 'Pasapasi 2ta banner er bam dik. Sudhu 1ta banner dekhabe.',
        ],
        'dual_right' => [
            'group' => 'Dual Banner',
            'label' => 'Dual - Right',
            'size'  => '645 × 330 px',
            'note'  => 'Pasapasi 2ta banner er dan dik. Sudhu 1ta banner dekhabe.',
        ],
    ];

    protected $fillable = [
        'title',
        'image',
        'link',
        'position',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status'     => 'boolean',
        'sort_order' => 'integer',
    ];

    public static function positionLabels(): array
    {
        return collect(self::POSITIONS)->map(fn ($p) => $p['label'])->all();
    }

    public static function positionGroups(): array
    {
        return collect(self::POSITIONS)->groupBy('group', true)->toArray();
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopePosition($query, string $position)
    {
        return $query->where('position', $position);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }

    public function getImageUrlAttribute(): string
    {
        return asset('uploads/banners/' . $this->image);
    }
}