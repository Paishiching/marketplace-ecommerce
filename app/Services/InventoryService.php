<?php

namespace App\Services;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Collection;

class InventoryService
{
    public function all(): Collection
    {
        return Inventory::all();
    }

    public function paginate(int $perPage = 20)
    {
        return Inventory::latest()->paginate($perPage);
    }

    public function find(int $id): Inventory
    {
        return Inventory::findOrFail($id);
    }

    public function create(array $data): Inventory
    {
        return Inventory::create($data);
    }

    public function update(int $id, array $data): Inventory
    {
        $record = Inventory::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = Inventory::findOrFail($id);

        return (bool) $record->delete();
    }
}
