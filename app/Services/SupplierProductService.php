<?php

namespace App\Services;

use App\Models\SupplierProduct;
use Illuminate\Database\Eloquent\Collection;

class SupplierProductService
{
    public function all(): Collection
    {
        return SupplierProduct::all();
    }

    public function paginate(int $perPage = 20)
    {
        return SupplierProduct::latest()->paginate($perPage);
    }

    public function find(int $id): SupplierProduct
    {
        return SupplierProduct::findOrFail($id);
    }

    public function create(array $data): SupplierProduct
    {
        return SupplierProduct::create($data);
    }

    public function update(int $id, array $data): SupplierProduct
    {
        $record = SupplierProduct::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = SupplierProduct::findOrFail($id);

        return (bool) $record->delete();
    }
}
