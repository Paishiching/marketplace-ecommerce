<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    protected function customer(): Customer
    {
        return Customer::firstOrCreate(['user_id' => Auth::id()]);
    }

    public function dashboard()
    {
        $customer = $this->customer();
        $base     = Order::where('customer_id', $customer->id);

        $stats = [
            'total'   => (clone $base)->count(),
            'pending' => (clone $base)->where('status', 'pending')->count(),
            'spent'   => (float) (clone $base)->where('status', '!=', 'cancelled')->sum('total'),
        ];

        $orders = (clone $base)->with(['orderItems', 'shipments'])->latest()->take(5)->get();
        $shipments = Shipment::whereHas('order', fn ($query) => $query->where('customer_id', $customer->id))
            ->with('order')->latest()->paginate(10, ['*'], 'deliveries_page');

        return view('customer.account.dashboard', compact('stats', 'orders', 'shipments'));
    }

    public function updateShipmentRemark(Request $request, Shipment $shipment)
    {
        $customer = $this->customer();
        abort_unless($shipment->order()->where('customer_id', $customer->id)->exists(), 404);

        $data = $request->validate(['customer_remark' => ['nullable', 'string', 'max:1000']]);
        $shipment->update(['customer_remark' => $data['customer_remark'] ?? null]);

        return back()->with('success', 'Your delivery remark was updated.');
    }

    public function orders()
    {
        $orders = Order::where('customer_id', $this->customer()->id)
            ->with(['orderItems', 'shipments'])
            ->latest()
            ->paginate(10);

        return view('customer.account.orders', compact('orders'));
    }

    public function addresses()
    {
        $addresses = $this->customer()->shippingAddress()->latest()->get();

        return view('customer.account.addresses', compact('addresses'));
    }

    public function addressDestroy($address)
    {
        $this->customer()->shippingAddress()->findOrFail($address)->delete();

        return back()->with('success', 'Address deleted.');
    }

    public function addressEdit($address)
    {
        $address = $this->customer()->shippingAddress()->findOrFail($address);

        return view('customer.account.address-edit', compact('address'));
    }

    public function addressUpdate(Request $request, $address)
    {
        $address = $this->customer()->shippingAddress()->findOrFail($address);
        $data = $request->validate([
            'recipient_name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:20'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
        ]);

        $address->update($data);

        return redirect()->route('account.addresses')->with('success', 'Address updated successfully.');
    }

    public function profile()
    {
        $user     = Auth::user();
        $customer = $this->customer();
        $phone    = $user->phone ?? $customer->phone ?? '';

        return view('customer.account.profile', compact('user', 'customer', 'phone'));
    }

    public function profileUpdate(Request $request)
    {
        $data = $request->validate([
            'name'          => ['required', 'string', 'max:120'],
            'phone'         => ['nullable', 'regex:/^01[3-9]\d{8}$/'],
            'gender'        => ['nullable', 'in:male,female,other'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'avatar'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'phone.regex' => 'Please enter a valid Bangladeshi mobile number (01XXXXXXXXX).',
        ]);

        $user     = Auth::user();
        $customer = $this->customer();

        if ($request->hasFile('avatar')) {
            $oldAvatar = $user->avatar;
            $data['avatar'] = $request->file('avatar')->store('users/avatars', 'public');
            if ($oldAvatar && ! str_starts_with($oldAvatar, 'http')) {
                Storage::disk('public')->delete($oldAvatar);
            }
        }

        $userValues = ['name' => $data['name']];
        if (isset($data['avatar'])) $userValues['avatar'] = $data['avatar'];
        if (Schema::hasColumn('users', 'phone')) {
            $userValues['phone'] = $data['phone'] ?? null;
        }
        $user->forceFill($userValues)->save();

        $customerValues = [
            'gender'        => $data['gender'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
        ];
        if (Schema::hasColumn('customers', 'phone')) {
            $customerValues['phone'] = $data['phone'] ?? null;
        }
        $customer->forceFill($customerValues)->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function password()
    {
        $hasPassword = ! is_null(Auth::user()->password_set_at);

        // OTP diye 30 minute er moddhe login korle current password lagbe na
        $needsCurrent = $hasPassword && ! $this->recentOtpLogin();

        return view('customer.account.password', compact('hasPassword', 'needsCurrent'));
    }

    public function passwordUpdate(Request $request)
    {
        $user         = Auth::user();
        $hasPassword  = ! is_null($user->password_set_at);
        $needsCurrent = $hasPassword && ! $this->recentOtpLogin();

        $rules = [
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ];

        if ($needsCurrent) {
            $rules['current_password'] = ['required', 'current_password'];
        }

        $request->validate($rules);

        $user->forceFill([
            'password'        => Hash::make($request->input('password')),
            'password_set_at' => now(),
        ])->save();

        return back()->with('success', $hasPassword
            ? 'Password changed successfully.'
            : 'Password set successfully. Now you can login with email and password.');
    }

    /** Last 30 minute er moddhe OTP verify kora hoyeche kina */
    protected function recentOtpLogin(): bool
    {
        $at = session('otp_verified_at');

        return $at && (now()->timestamp - (int) $at) <= 1800;
    }
}
