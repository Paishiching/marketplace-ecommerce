<?php

namespace App\Services;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Collection;

class PromotionService
{
    public function all(): Collection
    {
        return Promotion::all();
    }

    public function paginate(int $perPage = 20)
    {
        return Promotion::latest()->paginate($perPage);
    }

    public function find(int $id): Promotion
    {
        return Promotion::findOrFail($id);
    }

    public function create(array $data): Promotion
    {
        return Promotion::create($data);
    }

    public function update(int $id, array $data): Promotion
    {
        $record = Promotion::findOrFail($id);
        $record->update($data);

        return $record;
    }

    public function delete(int $id): bool
    {
        $record = Promotion::findOrFail($id);

        return (bool) $record->delete();
    }
}
