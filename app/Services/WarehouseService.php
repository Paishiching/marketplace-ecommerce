<?php

namespace App\Services;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Collection;

class WarehouseService
{
    public function all(): Collection
    {
        return Warehouse::all();
    }

    public function paginate(int $perPage = 20)
    {
        return Warehouse::latest()->paginate($perPage);
    }

    public function find(int $id): Warehouse
    {
        return Warehouse::findOrFail($id);
    }

    public function create(array $data): Warehouse
    {
        return Warehouse::create($data);
    }

    public function update(int $id, array $data): Warehouse
    {
        $record = Warehouse::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = Warehouse::findOrFail($id);

        return (bool) $record->delete();
    }
}
