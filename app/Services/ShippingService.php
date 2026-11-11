<?php

namespace App\Services;

use App\Models\ShippingRate;
use App\Models\ShippingZone;
use Illuminate\Database\Eloquent\Collection;

class ShippingService
{
    /**
     * Checkout-এ ব্যবহার হয় — কাস্টমারের city/district অনুযায়ী
     * সঠিক ShippingZone আর তার Rate বের করা।
     *
     * @return array{zone: ShippingZone|null, rate: ShippingRate|null}
     */
    public function resolve(?string $region): array
    {
        $zone = $this->matchZone($region);

        if (! $zone) {
            $zone = $this->fallbackZone();
        }

        return [
            'zone' => $zone,
            'rate' => $zone ? $this->pickRate($zone) : null,
        ];
    }

    /**
     * শুধু shipping cost (float) দরকার হলে এই শর্টকাট ব্যবহার করুন।
     */
    public function getShippingCost(?string $region): float
    {
        $resolved = $this->resolve($region);

        return $resolved['rate'] ? (float) $resolved['rate']->rate : 0.0;
    }

    /**
     * নির্দিষ্ট region (city/district নাম) কোন zone-এর মধ্যে পড়ে, সেটা বের করা।
     * Case-insensitive ম্যাচ করা হয় ("dhaka" == "Dhaka")।
     */
    protected function matchZone(?string $region): ?ShippingZone
    {
        if (empty($region)) {
            return null;
        }

        $region = trim($region);

        return ShippingZone::where('status', true)
            ->get()
            ->first(function (ShippingZone $zone) use ($region) {
                return collect($zone->regions ?? [])->contains(
                    fn ($r) => strcasecmp(trim($r), $region) === 0
                );
            });
    }

    /**
     * কোনো zone-এ ম্যাচ না হলে "OTHERS" ট্যাগযুক্ত fallback zone ব্যবহার হয়।
     * (SuperAdmin থেকে একটা zone বানিয়ে regions-এ ["OTHERS"] দিয়ে দিতে হবে)
     */
    protected function fallbackZone(): ?ShippingZone
    {
        return ShippingZone::where('status', true)
            ->get()
            ->first(function (ShippingZone $zone) {
                return collect($zone->regions ?? [])->contains(
                    fn ($r) => strcasecmp(trim($r), 'OTHERS') === 0
                );
            });
    }

    /**
     * একটা zone-এর একাধিক rate থাকতে পারে (future: Standard/Express)।
     * আপাতত সবচেয়ে কম rate-টা ডিফল্ট হিসেবে নেওয়া হচ্ছে।
     */
    protected function pickRate(ShippingZone $zone, ?string $rateName = null): ?ShippingRate
    {
        $rates = $zone->shippingRates;

        if ($rateName) {
            $match = $rates->first(fn ($r) => strcasecmp($r->name, $rateName) === 0);
            if ($match) {
                return $match;
            }
        }

        return $rates->sortBy('rate')->first();
    }

    public function all(): Collection
    {
        return ShippingRate::all();
    }
    public function paginate(int $perPage = 20)
    {
        return ShippingRate::latest()->paginate($perPage);
    }

    public function find(int $id): ShippingRate
    {
        return ShippingRate::findOrFail($id);
    }

    public function create(array $data): ShippingRate
    {
        return ShippingRate::create($data);
    }

    public function update(int $id, array $data): ShippingRate
    {
        $record = ShippingRate::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = ShippingRate::findOrFail($id);

        return (bool) $record->delete();
    }
}
