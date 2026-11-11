<?php

namespace App\Services;

use App\Models\ProductSync;
use Illuminate\Database\Eloquent\Collection;

class ProductSyncService
{
    public function all(): Collection
    {
        return ProductSync::all();
    }

    public function paginate(int $perPage = 20)
    {
        return ProductSync::latest()->paginate($perPage);
    }

    public function find(int $id): ProductSync
    {
        return ProductSync::findOrFail($id);
    }

    public function create(array $data): ProductSync
    {
        return ProductSync::create($data);
    }

    public function update(int $id, array $data): ProductSync
    {
        $record = ProductSync::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = ProductSync::findOrFail($id);

        return (bool) $record->delete();
    }
}
