<?php

namespace App\Http\Controllers\Vendor\Finance;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Withdrawal;
use App\Support\VendorWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WithdrawalController extends Controller
{
    public const METHODS = ['bKash', 'Nagad', 'Rocket', 'Bank'];

    public function index()
    {
        $vendor = $this->vendor();

        $withdrawals = Withdrawal::where('withdrawable_type', Vendor::class)
            ->where('withdrawable_id', $vendor->id)
            ->latest('id')
            ->paginate(15);

        $wallet  = VendorWallet::summary($vendor);
        $minimum = VendorWallet::MIN_WITHDRAWAL;
        $methods = self::METHODS;

        return view('vendor.withdrawals.index', compact('withdrawals', 'wallet', 'minimum', 'methods'));
    }

    public function store(Request $request)
    {
        $vendor = $this->vendor();

        $data = $request->validate([
            'amount'          => ['required', 'numeric', 'min:' . VendorWallet::MIN_WITHDRAWAL],
            'method'          => ['required', 'in:' . implode(',', self::METHODS)],
            'account_details' => ['required', 'string', 'max:500'],
        ], [
            'amount.min' => 'Minimum withdraw ৳' . VendorWallet::MIN_WITHDRAWAL . '.',
        ]);

        DB::transaction(function () use ($vendor, $data) {
            // Duto request ekshathe elew balance-er beshi jeno na jay
            Vendor::whereKey($vendor->id)->lockForUpdate()->first();

            $available = VendorWallet::summary($vendor)['available'];

            if ((float) $data['amount'] > $available) {
                throw ValidationException::withMessages([
                    'amount' => 'Available balance ৳' . number_format($available, 2) . ' er beshi withdraw kora jabe na.',
                ]);
            }

            Withdrawal::create([
                'withdrawable_type' => Vendor::class,
                'withdrawable_id'   => $vendor->id,
                'amount'            => $data['amount'],
                'method'            => $data['method'],
                'account_details'   => $data['account_details'],
                'status'            => 'pending',
            ]);
        });

        return redirect()->route('vendor.finance.withdrawals.index')
            ->with('success', 'Withdraw request jomma hoyeche. Admin approve korle taka pathano hobe.');
    }

    private function vendor(): Vendor
    {
        $vendor = Vendor::where('user_id', auth()->id())->first();

        abort_unless(
            $vendor && in_array((string) $vendor->status, ['approved', '1'], true),
            403,
            'Apnar vendor account ekhono approved noi.'
        );

        return $vendor;
    }
}