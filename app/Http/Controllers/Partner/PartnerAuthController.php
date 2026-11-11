<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PartnerAuthController extends Controller
{
    private const TYPES = [
        'supplier' => ['role' => 'supplier', 'profile' => 'supplier', 'label' => 'Supplier', 'login' => 'supplier.login', 'submit' => 'supplier.login.submit', 'register' => 'supplier.register', 'dashboard' => 'supplier.dashboards'],
        'affiliate' => ['role' => 'affiliate', 'profile' => 'affiliate', 'label' => 'Affiliate', 'login' => 'affiliate.login', 'submit' => 'affiliate.login.submit', 'register' => 'affiliate.register', 'dashboard' => 'affiliate.dashboards'],
        'reseller' => ['role' => 'reseller', 'profile' => 'reseller', 'label' => 'Reseller', 'login' => 'reseller.login', 'submit' => 'reseller.login.submit', 'register' => 'reseller.register', 'dashboard' => 'reseller.dashboards'],
        'dropshipping' => ['role' => 'dropshipping', 'profile' => 'dropshipper', 'label' => 'Dropshipping Partner', 'login' => 'dropshipping.login', 'submit' => 'dropshipping.login.submit', 'register' => 'dropshipping.register', 'dashboard' => 'dropshipping.dashboards'],
        'wholesale' => ['role' => 'wholesale', 'profile' => 'wholesaler', 'label' => 'Wholesale Partner', 'login' => 'wholesale.login', 'submit' => 'wholesale.login.submit', 'register' => 'wholesale.register', 'dashboard' => 'wholesale.dashboards'],
    ];

    public function showLogin(string $type): View|RedirectResponse
    {
        $config = self::TYPES[$type] ?? abort(404);
        $user = Auth::user();

        if ($user?->hasRole($config['role']) && $user->{$config['profile']}?->status === 'approved') {
            return redirect()->route($config['dashboard']);
        }

        return view('partners.auth.login', compact('config', 'type'));
    }

    public function login(Request $request, string $type): RedirectResponse
    {
        $config = self::TYPES[$type] ?? abort(404);
        $credentials = $request->validate([
            'email' => ['required', 'email:rfc', 'max:150'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withInput($request->only('email'))
                ->withErrors(['email' => 'The email or password is incorrect.']);
        }

        $request->session()->regenerate();
        $user = Auth::user();
        $profile = $user?->{$config['profile']};

        if (! $user?->hasRole($config['role']) || ! $profile || $profile->status !== 'approved') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = $profile?->status === 'pending'
                ? 'Your application is waiting for approval. Please sign in after it is approved.'
                : ($profile?->status === 'rejected'
                    ? 'Your application was rejected. Please contact support if you need help.'
                : ($profile?->status === 'suspended'
                    ? 'This account is suspended. Please contact support.'
                    : 'No approved ' . strtolower($config['label']) . ' account was found for these credentials.'));

            return redirect()->route($config['login'])->withErrors(['email' => $message]);
        }

        return redirect()->intended(route($config['dashboard']));
    }

    public function logout(Request $request, string $type): RedirectResponse
    {
        $config = self::TYPES[$type] ?? abort(404);
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($config['login'])->with('status', 'You have been signed out.');
    }
}
