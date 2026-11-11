<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /* ---------------- Website Settings ---------------- */

    public function website()
    {
        $settings = WebsiteSetting::current();

        return view('superadmin.settings.edit', compact('settings'));
    }

    public function updateWebsite(Request $request)
    {
        $settings = WebsiteSetting::current();

        $validated = $request->validate([
            'site_name'      => 'nullable|string|max:255',
            'tagline'        => 'nullable|string|max:255',
            'logo'           => 'nullable|image|max:1024',
            'logo_dark'      => 'nullable|image|max:1024',
            'favicon'        => 'nullable|image|mimes:png,ico,jpg,jpeg|max:512',
            'footer_about'   => 'nullable|string',
            'copyright_text' => 'nullable|string|max:255',

            'phone_1'         => 'nullable|string|max:20',
            'phone_2'         => 'nullable|string|max:20',
            'phone_3'         => 'nullable|string|max:20',
            'phone_4'         => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'messenger_link'  => 'nullable|url|max:255',
            'email_1'         => 'nullable|email|max:255',
            'email_2'         => 'nullable|email|max:255',
            'email_3'         => 'nullable|email|max:255',
            'address'         => 'nullable|string',

            'google_map_1' => 'nullable|string',
            'google_map_2' => 'nullable|string',

            'facebook_url'  => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url'   => 'nullable|url|max:255',
            'youtube_url'   => 'nullable|url|max:255',
            'linkedin_url'  => 'nullable|url|max:255',
            'tiktok_url'    => 'nullable|url|max:255',
            'pinterest_url' => 'nullable|url|max:255',

            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:500',
            'og_image'         => 'nullable|image|max:2048',

            'google_analytics_id'   => 'nullable|string|max:50',
            'google_tag_manager_id' => 'nullable|string|max:50',
            'facebook_pixel_id'     => 'nullable|string|max:50',
            'tiktok_pixel_id'       => 'nullable|string|max:50',

            'recaptcha_site_key'   => 'nullable|string|max:255',
            'recaptcha_secret_key' => 'nullable|string|max:255',

            'currency_code'            => 'nullable|string|max:10',
            'currency_symbol'          => 'nullable|string|max:5',
            'free_shipping_min_amount' => 'nullable|numeric|min:0',
            'cod_enabled'              => 'nullable|boolean',
            'maintenance_mode'         => 'nullable|boolean',
        ]);

        // Checkbox unchecked থাকলে request এ আসে না, তাই false ধরতে হবে
        $validated['cod_enabled'] = $request->boolean('cod_enabled');
        $validated['maintenance_mode'] = $request->boolean('maintenance_mode');

        // Image uploads
        foreach (['logo', 'logo_dark', 'favicon', 'og_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($settings->$field) {
                    Storage::disk('public')->delete($settings->$field);
                }
                $validated[$field] = $request->file($field)->store('settings', 'public');
            } else {
                // নতুন file না দিলে পুরনো image যেন null না হয়ে যায়
                unset($validated[$field]);
            }
        }

        $settings->update($validated);

        WebsiteSetting::clearCache();

        return redirect()
            ->route('superadmin.settings.website')
            ->with('success', 'Website settings updated successfully.');
    }

    /* ---------------- Payment / Shipping / Commission ----------------
       এগুলো এখনো তৈরি হয়নি। আপাতত sidebar link ভাঙবে না, শুধু info message দেখাবে। */

    public function payment()
    {
        return $this->comingSoon('Payment Settings');
    }

    public function updatePayment(Request $request)
    {
        return $this->comingSoon('Payment Settings');
    }

    public function shipping()
    {
        return $this->comingSoon('Shipping Settings');
    }

    public function updateShipping(Request $request)
    {
        return $this->comingSoon('Shipping Settings');
    }

    public function commission()
    {
        return $this->comingSoon('Commission Settings');
    }

    public function updateCommission(Request $request)
    {
        return $this->comingSoon('Commission Settings');
    }

    private function comingSoon(string $title)
    {
        return redirect()
            ->route('superadmin.settings.website')
            ->with('info', $title . ' page is coming soon.');
    }
}
