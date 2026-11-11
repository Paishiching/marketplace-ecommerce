<?php

namespace App\Services;

use App\Models\DropshippingProduct;
use Illuminate\Database\Eloquent\Collection;

class DropshippingProductService
{
    public function all(): Collection
    {
        return DropshippingProduct::all();
    }

    public function paginate(int $perPage = 20)
    {
        return DropshippingProduct::latest()->paginate($perPage);
    }

    public function find(int $id): DropshippingProduct
    {
        return DropshippingProduct::findOrFail($id);
    }

    public function create(array $data): DropshippingProduct
    {
        return DropshippingProduct::create($data);
    }

    public function update(int $id, array $data): DropshippingProduct
    {
        $record = DropshippingProduct::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = DropshippingProduct::findOrFail($id);

        return (bool) $record->delete();
    }
}
