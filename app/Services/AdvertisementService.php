<?php

namespace App\Services;

use App\Models\Advertisement;
use Illuminate\Database\Eloquent\Collection;

class AdvertisementService
{
    public function all(): Collection
    {
        return Advertisement::all();
    }

    public function paginate(int $perPage = 20)
    {
        return Advertisement::latest()->paginate($perPage);
    }

    public function find(int $id): Advertisement
    {
        return Advertisement::findOrFail($id);
    }

    public function create(array $data): Advertisement
    {
        return Advertisement::create($data);
    }

    public function update(int $id, array $data): Advertisement
    {
        $record = Advertisement::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = Advertisement::findOrFail($id);

        return (bool) $record->delete();
    }
}
