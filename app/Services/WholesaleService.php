<?php

namespace App\Services;

use App\Models\WholesaleProduct;
use Illuminate\Database\Eloquent\Collection;

class WholesaleService
{
    public function all(): Collection
    {
        return WholesaleProduct::all();
    }

    public function paginate(int $perPage = 20)
    {
        return WholesaleProduct::latest()->paginate($perPage);
    }

    public function find(int $id): WholesaleProduct
    {
        return WholesaleProduct::findOrFail($id);
    }

    public function create(array $data): WholesaleProduct
    {
        return WholesaleProduct::create($data);
    }

    public function update(int $id, array $data): WholesaleProduct
    {
        $record = WholesaleProduct::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = WholesaleProduct::findOrFail($id);

        return (bool) $record->delete();
    }
}
