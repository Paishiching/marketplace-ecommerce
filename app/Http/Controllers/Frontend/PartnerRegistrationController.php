<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\Reseller;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Dropshipper;
use App\Models\Wholesaler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PartnerRegistrationController extends Controller
{
    private function types(): array
    {
        return [
            'vendor' => [
                'model' => Vendor::class,
                'title' => 'Become a Vendor',
                'sub'   => 'Open your shop, list your products, and start selling after your application is approved.',
            ],
            'supplier' => [
                'model' => Supplier::class,
                'title' => 'Become a Supplier',
                'sub'   => 'Supply products to the marketplace after your application is approved.',
            ],
            'affiliate' => [
                'model' => Affiliate::class,
                'title' => 'Become an Affiliate',
                'sub'   => 'Promote marketplace products and earn commission after approval.',
            ],
            'reseller' => [
                'model' => Reseller::class,
                'title' => 'Become a Reseller',
                'sub'   => 'Resell marketplace products with your own margin after approval.',
            ],
            'dropshipping' => [
                'model' => Dropshipper::class,
                'title' => 'Become a Dropshipping Partner',
                'sub' => 'Apply to build a dropshipping business using the marketplace catalog.',
            ],
            'wholesale' => [
                'model' => Wholesaler::class,
                'title' => 'Become a Wholesale Partner',
                'sub' => 'Apply to manage bulk purchasing and wholesale business activity.',
            ],
        ];
    }

    public function create(string $type)
    {
        $cfg = $this->types()[$type] ?? abort(404);

        if (Auth::check() && $cfg['model']::where('user_id', Auth::id())->exists()) {
            return redirect()->route('customer.dashboard')
                ->with('success', 'Apni already apply korechen.');
        }

        return view('frontend.partner.register', [
            'type' => $type,
            'cfg' => $cfg,
            'registrationRoute' => request()->routeIs($type . '.register')
                ? $type . '.register.submit'
                : 'become-' . $type . '.store',
        ]);
    }

    public function store(Request $request, string $type)
    {
        $cfg   = $this->types()[$type] ?? abort(404);
        $model = $cfg['model'];
        $dedicatedRegistration = in_array($type, ['vendor', 'supplier', 'affiliate', 'reseller', 'dropshipping', 'wholesale'], true)
            && $request->routeIs($type . '.register.submit');

        if (Auth::check() && $model::where('user_id', Auth::id())->exists()) {
            return redirect()->route('customer.dashboard')
                ->with('success', 'Apni already apply korechen.');
        }

        $rules = [];

        if ($type === 'vendor') {
            $rules += [
                'shop_name'   => ['required', 'string', 'max:120'],
                'description' => ['nullable', 'string', 'max:1000'],
                'logo'        => ['nullable', 'image', 'max:2048'],
            ];
        } elseif ($type === 'supplier') {
            $rules += [
                'company_name' => ['required', 'string', 'max:150'],
                'description'  => ['nullable', 'string', 'max:1000'],
                'logo'         => ['nullable', 'image', 'max:2048'],
            ];
        } elseif (in_array($type, ['reseller', 'dropshipping', 'wholesale'], true)) {
            $rules += ['business_name' => ['required', 'string', 'max:150']];
        }

        if (! Auth::check()) {
            $rules += [
                'name'     => ['required', 'string', 'max:100'],
                'email'    => ['required', 'email', 'max:150', 'unique:users,email'],
                'phone'    => ['required', 'string', 'max:20'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];
        }

        $data = $request->validate($rules);

        $userId = DB::transaction(function () use ($request, $data, $type, $model) {
            $user = Auth::user();

            if (! $user) {
                $user = new User();
                $user->forceFill([
                    'name'              => $data['name'],
                    'email'             => $data['email'],
                    'phone'             => $data['phone'],
                    'password'          => $data['password'], // model cast hash kore dey
                    'email_verified_at' => now(),
                ])->save();
            }

            $row = new $model();

            if ($type === 'vendor') {
                $row->forceFill([
                    'name'            => $user->name,
                    'user_id'         => $user->id,
                    'shop_name'       => $data['shop_name'],
                    'shop_slug'       => $this->uniqueSlug($model, 'shop_slug', $data['shop_name']),
                    'logo'            => $request->hasFile('logo') ? $request->file('logo')->store('vendors', 'public') : null,
                    'description'     => $data['description'] ?? null,
                    'commission_rate' => 0, // approve korar somoy SuperAdmin set korbe
                    'is_verified'     => false,
                    'status'          => 'pending',
                ]);
            } elseif ($type === 'supplier') {
                $row->forceFill([
                    'user_id'      => $user->id,
                    'company_name' => $data['company_name'],
                    'company_slug' => $this->uniqueSlug($model, 'company_slug', $data['company_name']),
                    'logo'         => $request->hasFile('logo') ? $request->file('logo')->store('suppliers', 'public') : null,
                    'description'  => $data['description'] ?? null,
                    'is_verified'  => false,
                    'status'       => 'pending',
                ]);
            } elseif ($type === 'affiliate') {
                $row->forceFill([
                    'user_id'         => $user->id,
                    'referral_code'   => $this->uniqueCode(),
                    'commission_rate' => 0,
                    'status'          => 'pending',
                ]);
            } else {
                $businessProfile = [
                    'user_id'       => $user->id,
                    'business_name' => $data['business_name'],
                    'status'        => 'pending',
                ];
                if ($type === 'reseller') {
                    $businessProfile['markup_rate'] = 0;
                }
                $row->forceFill($businessProfile);
            }

            $row->save();

            return $user->id;
        });

        if (! Auth::check() && ! $dedicatedRegistration) {
            Auth::login(User::find($userId));
        }

        if ($dedicatedRegistration) {
            return redirect()->route($type . '.login')->with('status', 'Your application has been submitted. You can sign in after Super Admin approval.');
        }

        return redirect()->route('customer.dashboard')
            ->with('success', 'Apnar application jomma hoyeche. Admin approve korle apni panel pabenn.');
    }

    private function uniqueSlug(string $model, string $column, string $name): string
    {
        $base = Str::slug($name) ?: 'partner';
        $slug = $base;
        $i = 1;

        while ($model::where($column, $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    private function uniqueCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (Affiliate::where('referral_code', $code)->exists());

        return $code;
    }
}
