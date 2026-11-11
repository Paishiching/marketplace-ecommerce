<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        $user = Auth::user();

        if ($user?->hasRole('vendor') && $user->vendor?->status === 'approved') {
            return redirect()->route('vendor.dashboards');
        }

        return view('vendor.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
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
        $vendor = $user?->vendor;

        if (! $user?->hasRole('vendor') || ! $vendor || $vendor->status !== 'approved') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = $vendor?->status === 'pending'
                ? 'Your vendor application is awaiting approval. You can sign in after it is approved.'
                : ($vendor?->status === 'suspended'
                    ? 'This vendor account is currently suspended. Please contact support.'
                    : 'No approved vendor account was found for these credentials.');

            return redirect()->route('vendor.login')->withErrors(['email' => $message]);
        }

        return redirect()->intended(route('vendor.dashboards'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('vendor.login')->with('status', 'You have been signed out.');
    }
}
