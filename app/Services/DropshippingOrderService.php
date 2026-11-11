<?php

namespace App\Services;

use App\Models\DropshippingOrder;
use Illuminate\Database\Eloquent\Collection;

class DropshippingOrderService
{
    public function all(): Collection
    {
        return DropshippingOrder::all();
    }

    public function paginate(int $perPage = 20)
    {
        return DropshippingOrder::latest()->paginate($perPage);
    }

    public function find(int $id): DropshippingOrder
    {
        return DropshippingOrder::findOrFail($id);
    }

    public function create(array $data): DropshippingOrder
    {
        return DropshippingOrder::create($data);
    }

    public function update(int $id, array $data): DropshippingOrder
    {
        $record = DropshippingOrder::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = DropshippingOrder::findOrFail($id);

        return (bool) $record->delete();
    }
}
