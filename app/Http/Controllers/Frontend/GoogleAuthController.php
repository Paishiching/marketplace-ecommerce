<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class GoogleAuthController extends Controller
{
    public function redirect(Request $request)
    {
        if (! config('services.google.client_id') || ! config('services.google.client_secret')) {
            return redirect()->route('otp.login')->withErrors([
                'email' => 'Google sign-in is not configured yet. Please use email verification for now.',
            ]);
        }

        $state = Str::random(48);
        $request->session()->put('google_oauth_state', $state);

        return redirect()->away('https://accounts.google.com/o/oauth2/v2/auth?'.http_build_query([
            'client_id' => config('services.google.client_id'),
            'redirect_uri' => config('services.google.redirect') ?: route('google.callback'),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'state' => $state,
            'prompt' => 'select_account',
        ]));
    }

    public function callback(Request $request, CartService $cartService)
    {
        $expectedState = (string) $request->session()->pull('google_oauth_state', '');
        $receivedState = (string) $request->query('state', '');
        if ($expectedState === '' || ! hash_equals($expectedState, $receivedState)) {
            return redirect()->route('otp.login')->withErrors(['email' => 'Google sign-in expired. Please try again.']);
        }

        if ($request->filled('error') || ! $request->filled('code')) {
            return redirect()->route('otp.login')->withErrors(['email' => 'Google sign-in was cancelled.']);
        }

        try {
            $tokenResponse = Http::asForm()->timeout(12)->post('https://oauth2.googleapis.com/token', [
                'code' => $request->query('code'),
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'redirect_uri' => config('services.google.redirect') ?: route('google.callback'),
                'grant_type' => 'authorization_code',
            ]);

            if (! $tokenResponse->successful() || ! $tokenResponse->json('access_token')) {
                throw new \RuntimeException('Google token exchange failed.');
            }

            $profileResponse = Http::withToken($tokenResponse->json('access_token'))
                ->timeout(12)
                ->get('https://www.googleapis.com/oauth2/v2/userinfo');

            if (! $profileResponse->successful()) {
                throw new \RuntimeException('Google profile request failed.');
            }

            $profile = $profileResponse->json();
            $email = Str::lower(trim((string) ($profile['email'] ?? '')));
            if (! filter_var($email, FILTER_VALIDATE_EMAIL) || ! ($profile['verified_email'] ?? false)) {
                return redirect()->route('otp.login')->withErrors(['email' => 'Google could not verify this email address.']);
            }
        } catch (\Throwable $e) {
            Log::warning('Google customer sign-in failed: '.$e->getMessage());
            return redirect()->route('otp.login')->withErrors(['email' => 'Google sign-in could not be completed. Please try again.']);
        }

        $user = User::where('email', $email)->first();
        if ($user && $user->roles()->where('name', '!=', 'customer')->exists()) {
            return redirect()->route('otp.login')->withErrors(['email' => 'This email belongs to a staff account. Please use the staff login.']);
        }

        if (! $user) {
            $attributes = [
                'name' => trim((string) ($profile['name'] ?? Str::before($email, '@'))),
                'email' => $email,
                'password' => Str::random(48),
                'email_verified_at' => now(),
                'avatar' => $profile['picture'] ?? null,
            ];
            if (Schema::hasColumn('users', 'status')) {
                $numericStatus = in_array(strtolower((string) Schema::getColumnType('users', 'status')), ['int', 'integer', 'tinyint', 'smallint', 'mediumint', 'bigint', 'boolean', 'bool'], true);
                $attributes['status'] = $numericStatus ? 1 : 'active';
            }
            $user = User::create($attributes);
        } elseif (! $user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        if (Role::where('name', 'customer')->exists() && ! $user->hasRole('customer')) {
            $user->assignRole('customer');
        }

        $customer = Customer::firstOrCreate(['user_id' => $user->id]);
        Auth::login($user, false);
        $request->session()->regenerate();
        $request->session()->forget('otp_verified_at');
        $cartService->mergeGuestCartIntoCustomer($customer->id);

        return redirect()->intended(route('homes'));
    }
}
