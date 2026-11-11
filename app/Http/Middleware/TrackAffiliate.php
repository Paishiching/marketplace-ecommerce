<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AffiliateLink;
use App\Models\AffiliateClick;

/**
 * Detects an affiliate reference code in the URL (?ref=CODE), logs
 * the click, and stores the affiliate id in the session/cookie so
 * the sale can be attributed later at checkout.
 */
class TrackAffiliate
{
    public function handle(Request $request, Closure $next)
    {
        $refCode = $request->query('ref');

        if ($refCode) {
            $link = AffiliateLink::where('code', $refCode)->first();

            if ($link) {
                AffiliateClick::create([
                    'affiliate_link_id' => $link->id,
                    'affiliate_id' => $link->affiliate_id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);

                $request->session()->put('affiliate_id', $link->affiliate_id);
                $request->session()->put('affiliate_link_id', $link->id);

                cookie()->queue(cookie('affiliate_ref', $refCode, 60 * 24 * 30));
            }
        }

        return $next($request);
    }
}
