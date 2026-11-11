<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $table = 'website_settings';

    protected $fillable = [
        'site_name', 'tagline', 'logo', 'logo_dark', 'favicon',
        'footer_about', 'copyright_text',

        'phone_1', 'phone_2', 'phone_3', 'phone_4',
        'whatsapp_number', 'messenger_link',
        'email_1', 'email_2', 'email_3',
        'address',

        'google_map_1', 'google_map_2',

        'facebook_url', 'instagram_url', 'twitter_url', 'youtube_url',
        'linkedin_url', 'tiktok_url', 'pinterest_url',

        'meta_title', 'meta_description', 'meta_keywords', 'og_image',

        'google_analytics_id', 'google_tag_manager_id',
        'facebook_pixel_id', 'tiktok_pixel_id',

        'recaptcha_site_key', 'recaptcha_secret_key',

        'currency_code', 'currency_symbol', 'free_shipping_min_amount',
        'cod_enabled', 'maintenance_mode',
    ];

    protected $casts = [
        'cod_enabled'              => 'boolean',
        'maintenance_mode'         => 'boolean',
        'free_shipping_min_amount' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::saved(fn () => static::clearCache());
        static::deleted(fn () => static::clearCache());
    }

    public static function current(): self
    {
        return Cache::rememberForever('website_settings', function () {
            return self::firstOrCreate(['id' => 1]);
        });
    }

    public static function clearCache(): void
    {
        Cache::forget('website_settings');
    }
}
