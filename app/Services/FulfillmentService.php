<?php

namespace App\Services;

use App\Models\DropshippingFulfillment;
use Illuminate\Database\Eloquent\Collection;

class FulfillmentService
{
    public function all(): Collection
    {
        return DropshippingFulfillment::all();
    }

    public function paginate(int $perPage = 20)
    {
        return DropshippingFulfillment::latest()->paginate($perPage);
    }

    public function find(int $id): DropshippingFulfillment
    {
        return DropshippingFulfillment::findOrFail($id);
    }

    public function create(array $data): DropshippingFulfillment
    {
        return DropshippingFulfillment::create($data);
    }

    public function update(int $id, array $data): DropshippingFulfillment
    {
        $record = DropshippingFulfillment::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = DropshippingFulfillment::findOrFail($id);

        return (bool) $record->delete();
    }
}
