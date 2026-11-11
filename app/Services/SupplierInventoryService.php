<?php

namespace App\Services;

use App\Models\SupplierInventory;
use Illuminate\Database\Eloquent\Collection;

class SupplierInventoryService
{
    public function all(): Collection
    {
        return SupplierInventory::all();
    }

    public function paginate(int $perPage = 20)
    {
        return SupplierInventory::latest()->paginate($perPage);
    }

    public function find(int $id): SupplierInventory
    {
        return SupplierInventory::findOrFail($id);
    }

    public function create(array $data): SupplierInventory
    {
        return SupplierInventory::create($data);
    }

    public function update(int $id, array $data): SupplierInventory
    {
        $record = SupplierInventory::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = SupplierInventory::findOrFail($id);

        return (bool) $record->delete();
    }
}
