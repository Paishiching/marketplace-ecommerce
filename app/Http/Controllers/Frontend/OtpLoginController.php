<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\EmailOtp;
use App\Models\User;
use App\Notifications\LoginOtpNotification;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class OtpLoginController extends Controller
{
    private const EXPIRE_MINUTES = 5;
    private const RESEND_SECONDS = 60;
    private const MAX_ATTEMPTS   = 5;

    public function __construct(protected CartService $cartService)
    {
    }

    /** Login page (email dewar page) */
    public function showLogin()
    {
        // Already login thakle verify lagbe na => home index
        if (Auth::check()) {
            return redirect()->intended(route('homes'));
        }

        return view('frontend.auth.otp-login');
    }

    /** OTP pathano */
    public function send(Request $request)
    {
        // phone e space/dash thakle muche felo, +88 / 88 prefix soriye 01XXXXXXXXX banao
        $rawPhone = preg_replace('/[\s\-]/', '', (string) $request->input('phone', ''));
        $rawPhone = preg_replace('/^(\+?88)(?=01)/', '', $rawPhone);
        $request->merge(['phone' => $rawPhone !== '' ? $rawPhone : null]);

        $data = $request->validate([
            'email' => ['required', 'email:rfc', 'max:150'],
            'phone' => ['nullable', 'regex:/^01[3-9]\d{8}$/'],
        ], [
            'phone.regex' => 'Please enter a valid Bangladeshi mobile number (01XXXXXXXXX).',
        ]);

        if (! $this->captchaPasses($request)) {
            return back()
                ->withInput()
                ->withErrors(['captcha' => 'Please confirm that you are not a robot.']);
        }

        $email = Str::lower(trim($data['email']));

        // Staff (admin/vendor/supplier...) email diye customer OTP login kora jabe na
        $existing = User::where('email', $email)->first();

        if ($existing && $this->isStaff($existing)) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'This email belongs to a staff account. Please use the staff login.']);
        }

        try {
            $this->issueOtp($email);
        } catch (\Throwable $e) {
            Log::error('OTP send failed: ' . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['email' => 'Could not send the verification code. Please try again.']);
        }

        $request->session()->put('otp_email', $email);
        $request->session()->put('otp_phone', $data['phone'] ?? null);

        return redirect()->route('otp.verify.form');
    }

    /** OTP verify page */
    public function showVerify(Request $request)
    {
        $email = $request->session()->get('otp_email');

        if (! $email) {
            return redirect()->route('otp.login');
        }

        $record = EmailOtp::where('email', $email)->first();
        $wait   = $this->secondsUntilResend($record);

        return view('frontend.auth.otp-verify', [
            'email' => $email,
            'wait'  => $wait,
        ]);
    }

    /** OTP check kore login */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Please enter the 6-digit code.',
            'otp.digits'   => 'The code must be 6 digits.',
        ]);

        $email = $request->session()->get('otp_email');

        if (! $email) {
            return redirect()->route('otp.login');
        }

        $record = EmailOtp::where('email', $email)->first();

        if (! $record || $record->expires_at->isPast()) {
            return back()->withErrors(['otp' => 'This code has expired. Please request a new one.']);
        }

        if ($record->attempts >= self::MAX_ATTEMPTS) {
            return back()->withErrors(['otp' => 'Too many wrong attempts. Please request a new code.']);
        }

        if (! Hash::check($request->input('otp'), $record->code_hash)) {
            $record->increment('attempts');

            return back()->withErrors(['otp' => 'The code you entered is incorrect.']);
        }

        // ---- Verified ----
        $record->delete();

        $user = $this->findOrCreateUser($email);

        // Extra safety : staff account hole customer login e dhukte dibe na
        if ($this->isStaff($user)) {
            $request->session()->forget(['otp_email', 'otp_phone']);

            return redirect()->route('otp.login')
                ->withErrors(['email' => 'This email belongs to a staff account. Please use the staff login.']);
        }

        // login page e deya phone ta account e save (checkout e auto boshbe)
        $this->rememberPhone($user, $request->session()->pull('otp_phone'));

        // remember = true => customer abar ashle verify korte hobe na
        Auth::login($user, true);
        $request->session()->regenerate();
        $request->session()->forget('otp_email');

        // OTP diye login hoyeche : 30 min porjonto password change e current password lagbe na
        $request->session()->put('otp_verified_at', now()->timestamp);

        // Guest cart er item gulo customer er cart e merge (login er por cart haraay na)
        $customer = Customer::firstOrCreate(['user_id' => $user->id]);
        $this->cartService->mergeGuestCartIntoCustomer($customer->id);

        // Login er age "Add to Cart / Buy Now" chap dile oi product ekhon cart e add hobe
        $pending = $request->session()->pull('pending_cart');
        if ($pending && ! empty($pending['product_id'])) {
            try {
                $this->cartService->addItem(
                    (int) $pending['product_id'],
                    ! empty($pending['variant_id']) ? (int) $pending['variant_id'] : null,
                    max(1, (int) ($pending['quantity'] ?? 1))
                );
            } catch (\Throwable $e) {
                Log::warning('Pending cart add failed after login: ' . $e->getMessage());
            }
        }

        // Buy Now => checkout ; Add to Cart => ager page ; kichu na thakle => home index
        return redirect()->intended(route('homes'));
    }

    /** Notun code pathano */
    public function resend(Request $request)
    {
        $email = $request->session()->get('otp_email');

        if (! $email) {
            return redirect()->route('otp.login');
        }

        $record = EmailOtp::where('email', $email)->first();
        $wait   = $this->secondsUntilResend($record);

        if ($wait > 0) {
            return back()->withErrors(['otp' => 'Please wait ' . $wait . ' seconds before requesting a new code.']);
        }

        try {
            $this->issueOtp($email);
        } catch (\Throwable $e) {
            Log::error('OTP resend failed: ' . $e->getMessage());

            return back()->withErrors(['otp' => 'Could not send the code. Please try again.']);
        }

        return back()->with('status', 'A new code has been sent to your email.');
    }

    /** Email + password diye login (customer dashboard theke password set korle) */
    public function passwordLogin(Request $request)
    {
        $email    = Str::lower(trim((string) $request->input('email')));
        $password = (string) $request->input('password');

        $user = $email !== '' ? User::where('email', $email)->first() : null;

        $ok = $user
            && $user->password_set_at
            && Hash::check($password, $user->password);

        if (! $ok) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['pw' => 'Email or password is incorrect. If you have not set a password, use the email code login.']);
        }

        if ($this->isStaff($user)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['pw' => 'This email belongs to a staff account. Please use the staff login.']);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        // Password diye login : OTP verified chinho thakbe na (password change e current password lagbe)
        $request->session()->forget('otp_verified_at');

        $customer = Customer::firstOrCreate(['user_id' => $user->id]);
        $this->cartService->mergeGuestCartIntoCustomer($customer->id);

        return redirect()->intended(route('homes'));
    }

    // ------------------------------------------------------------------

    /** Customer chhara onno kono role (admin, vendor...) thakle staff */
    protected function isStaff(User $user): bool
    {
        return $user->roles()->where('name', '!=', 'customer')->exists();
    }

    /**
     * Google reCAPTCHA v2 check. Site key set na thakle (local) check skip hoy.
     */
    protected function captchaPasses(Request $request): bool
    {
        if (! config('recaptcha.site_key') || ! config('recaptcha.secret_key')) {
            return true;
        }

        $token = $request->input('g-recaptcha-response');

        if (! $token) {
            return false;
        }

        try {
            $response = Http::asForm()->timeout(8)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => config('recaptcha.secret_key'),
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);

            return $response->json('success') === true;
        } catch (\Throwable $e) {
            Log::error('reCAPTCHA verify failed: ' . $e->getMessage());

            return false;
        }
    }

    protected function issueOtp(string $email): void
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        EmailOtp::updateOrCreate(
            ['email' => $email],
            [
                'code_hash'    => Hash::make($code),
                'attempts'     => 0,
                'expires_at'   => now()->addMinutes(self::EXPIRE_MINUTES),
                'last_sent_at' => now(),
            ]
        );

        Notification::route('mail', $email)
            ->notify(new LoginOtpNotification($code, self::EXPIRE_MINUTES));
    }

    protected function secondsUntilResend(?EmailOtp $record): int
    {
        if (! $record || ! $record->last_sent_at) {
            return 0;
        }

        $passed = $record->last_sent_at->diffInSeconds(now());

        return max(0, self::RESEND_SECONDS - (int) $passed);
    }

    protected function rememberPhone(User $user, ?string $phone): void
    {
        if (! $phone) {
            return;
        }

        $customer = Customer::firstOrCreate(['user_id' => $user->id]);

        foreach ([$customer, $user] as $model) {
            if (Schema::hasColumn($model->getTable(), 'phone')) {
                $model->forceFill(['phone' => $phone])->save();
            }
        }
    }

    protected function findOrCreateUser(string $email): User
    {
        $user = User::where('email', $email)->first();

        if (! $user) {
            $attributes = [
                'name'              => Str::title(str_replace(['.', '_', '-'], ' ', Str::before($email, '@'))),
                'email'             => $email,
                'password'          => Str::random(32),
                'email_verified_at' => now(),
            ];

            // users.status column integer (1 = active) hole 1, text hole 'active'
            if (Schema::hasColumn('users', 'status')) {
                $numeric = in_array(strtolower((string) Schema::getColumnType('users', 'status')),
                    ['int', 'integer', 'tinyint', 'smallint', 'mediumint', 'bigint', 'boolean', 'bool'], true);

                $attributes['status'] = $numeric ? 1 : 'active';
            }

            $user = User::create($attributes);
        } elseif (! $user->email_verified_at) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        // customer profile (checkout e Auth::user()->customer lage)
        Customer::firstOrCreate(['user_id' => $user->id]);

        // customer role (thakle)
        if (method_exists($user, 'assignRole')
            && Role::where('name', 'customer')->exists()
            && ! $user->hasRole('customer')) {
            $user->assignRole('customer');
        }

        return $user;
    }
}