<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AffiliateClick;
use App\Models\AffiliateLink;
use App\Services\AffiliateTrackingService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AffiliateController extends Controller
{
    public function track(Request $request, string $code)
    {
        $link = AffiliateLink::where('code', $code)
            ->where('is_active', true)
            ->firstOrFail();

        // Ekoi IP theke 1 ghontar moddhe ekoi link e abar click gunbe na
        $alreadyCounted = AffiliateClick::where('affiliate_link_id', $link->id)
            ->where('ip_address', $request->ip())
            ->where('created_at', '>=', now()->subHour())
            ->exists();

        if (!$alreadyCounted) {
            AffiliateClick::create([
                'affiliate_link_id' => $link->id,
                'ip_address'        => $request->ip(),
                'user_agent'        => Str::limit((string) $request->userAgent(), 250, ''),
                'referrer'          => Str::limit((string) $request->headers->get('referer'), 250, ''),
            ]);
        }

        return redirect()->to($link->target_url)->withCookie(
            cookie(AffiliateTrackingService::COOKIE, $link->code, AffiliateTrackingService::COOKIE_MINUTES)
        );
    }
}
