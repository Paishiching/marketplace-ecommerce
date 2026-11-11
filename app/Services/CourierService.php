<?php

namespace App\Services;

use App\Models\Courier;
use Illuminate\Database\Eloquent\Collection;

class CourierService
{
    public function all(): Collection
    {
        return Courier::all();
    }

    public function paginate(int $perPage = 20)
    {
        return Courier::latest()->paginate($perPage);
    }

    public function find(int $id): Courier
    {
        return Courier::findOrFail($id);
    }

    public function create(array $data): Courier
    {
        return Courier::create($data);
    }

    public function update(int $id, array $data): Courier
    {
        $record = Courier::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = Courier::findOrFail($id);

        return (bool) $record->delete();
    }
}
