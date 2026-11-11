<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePartnerApproved
{
    private const PROFILES = [
        'supplier' => ['relation' => 'supplier', 'label' => 'Supplier'],
        'affiliate' => ['relation' => 'affiliate', 'label' => 'Affiliate'],
        'reseller' => ['relation' => 'reseller', 'label' => 'Reseller'],
        'dropshipping' => ['relation' => 'dropshipper', 'label' => 'Dropshipping'],
        'wholesale' => ['relation' => 'wholesaler', 'label' => 'Wholesale'],
    ];

    public function handle(Request $request, Closure $next, string $type): Response
    {
        $config = self::PROFILES[$type] ?? abort(404);

        if (! $request->user()->hasRole($type)) {
            return response()->view('partners.auth.profile-status', [
                'label' => $config['label'],
                'status' => 'wrong_role',
                'loginRoute' => $type . '.login',
                'logoutRoute' => $type . '.logout',
                'applyRoute' => null,
            ]);
        }

        $profile = $request->user()->{$config['relation']};

        if (! $profile) {
            return response()->view('partners.auth.profile-status', [
                'label' => $config['label'],
                'status' => 'missing',
                'applyRoute' => $type . '.register',
                'logoutRoute' => $type . '.logout',
                'loginRoute' => $type . '.login',
            ]);
        }

        if ($profile->status !== 'approved') {
            $status = in_array($profile->status, ['pending', 'rejected', 'suspended'], true)
                ? $profile->status
                : 'pending';

            return response()->view('partners.auth.profile-status', [
                'label' => $config['label'],
                'status' => $status,
                'applyRoute' => null,
                'logoutRoute' => $type . '.logout',
                'loginRoute' => $type . '.login',
            ]);
        }

        return $next($request);
    }
}
